package components
{
	import com.esri.ags.Graphic;
	import com.esri.ags.SpatialReference;
	import com.esri.ags.geometry.Multipoint;
	import com.esri.ags.geometry.Polygon;
	import com.esri.ags.geometry.Polyline;
	import com.esri.ags.geometry.WebMercatorMapPoint;
	import com.esri.ags.symbols.SimpleFillSymbol;
	import com.esri.ags.symbols.SimpleLineSymbol;
	import com.esri.ags.symbols.SimpleMarkerSymbol;
	
	import mx.collections.ArrayCollection;
	import mx.utils.ObjectUtil;
	
	public class SQLFeature
	{
		// geometry type
		private static var feature:String;
		
		// return array of ESRI ArcGIS Flex API v2.2 Graphic objects
		public static function getGraphic(arr:ArrayCollection, boo:Boolean):Array
		{
			// initialize array of ESRI Graphic objects
			var graphic:Array = [];
			
			// ensure result set from SQL query contains records
			if (arr.length > 0)
			{
				var i:int;
				var j:int;
				var index:String;
				var LngLat:Array;
				var mapPoints:Array;
				// object introspection of the first object contained within the passed ArrayCollection "arr"
				var obj:Object = ObjectUtil.getClassInfo(arr[0]);
				// object property containing the geometry will have a value beginning with one of the following feature identifiers
				var pattern:RegExp = /(POINT \(|MULTIPOINT \(|LINESTRING \(|MULTILINESTRING \(|POLYGON \(|MULTIPOLYGON \()/;
				
				//iterate through all object properties discovered by object introspection
				for (i=0; i<obj.properties.length; i++)
				{
					// determine which object property value contains the geometry - TRUE returns a positive integer 
					if (arr[0][obj.properties[i].localName].toString().search(pattern) != -1)
					{
						// assign object property name
						index = obj.properties[i].localName;
						break;
					}
				}
				
				// iterate through all objects contained within ArrayCollection
				for (i=0; i<arr.length; i++)
				{
					// assign geometry type by extracting the lead characters (see "pattern" above) of the object property value containing the geometry as determined above	
					feature = arr[i][index].slice(0, arr[i][index].indexOf(" "));
					
					// create Attribute object parameter for ESRI Graphic object constructor if TRUE; otherwise NULL
					var attr:Object = new Object();
					
					if (boo)
					{
						// iterate through all object properties
						for (j=0; j<obj.properties.length; j++)
						{
							// include all object properties (attributes) EXCEPT object property containing the geometry
							if (obj.properties[j].localName != index)
							{
								// assign object property name and value to Attribute object
								attr[obj.properties[j].localName] = arr[i][obj.properties[j].localName];
							}
						}
					}
					else
						attr = null;
					
					// conditional logic depending upon specific geometry type
					switch(feature)
					{
						// extract Lng and Lat values from object property containing the geometry - ignoring lead characters declaring geometry type extracted above
						case "POINT":
							// eg. geometry contained within "index" property value: "POINT (-79.702306 44.382361)"
							LngLat = arr[i][index].slice(arr[i][index].indexOf("(") + 1, arr[i][index].indexOf(")")).split(" ");
							// add feature to graphic array containing ESRI Graphic objects, instantiated with Graphic constructor comprising feature geometry, symbolization and attributes
							graphic.push(new Graphic(new WebMercatorMapPoint(parseFloat(LngLat[0]), parseFloat(LngLat[1])), new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_DIAMOND, 10, 0xFF0000, 1), attr));
							break;
						
						// create an array of points containing Lng and Lat values
						case "MULTIPOINT":
							// eg. "MULTIPOINT (-79.702306 44.382361, -79.388111 43.662972, -76.528306 44.216251, -75.714194 45.382528)"
							mapPoints = arr[i][index].slice(arr[i][index].indexOf("(") + 1, arr[i][index].indexOf(")")).split(", ");
							break;
						
						// create an array of line vertices containing Lng and Lat values
						case "LINESTRING":
							// eg. "LINESTRING (-79.702306 44.382361, -79.388111 43.662972, -76.528306 44.216251, -75.714194 45.382528)"
							mapPoints = arr[i][index].slice(arr[i][index].indexOf("(") + 1, arr[i][index].indexOf(")")).split(", ");
							break;
						
						// create an array of individual LINESTRINGs
						case "MULTILINESTRING":
							// eg. "MULTILINESTRING ((-79.702306 44.382361, -79.388111 43.662972), (-76.528306 44.216251, -75.714194 45.382528))"
							mapPoints = arr[i][index].slice(arr[i][index].indexOf("((") + 2, arr[i][index].indexOf("))")).split("), (");
							break;
						
						// create an array of polygon vertices containing Lng and Lat values
						case "POLYGON":
							// eg. "POLYGON ((-79.702306 44.382361, -79.388111 43.662972, -76.528306 44.216251, -79.702306 44.382361))"
							mapPoints = arr[i][index].slice(arr[i][index].indexOf("((") + 2, arr[i][index].indexOf("))")).split(", ");
							break;
						
						// create an array of individual POLYGONs
						case "MULTIPOLYGON":
							// eg. "MULTIPOLYGON (((-79.702306 44.382361, -79.388111 43.662972, -76.528306 44.216251, -79.702306 44.382361)), ((-79.388111 43.662972, -76.528306 44.216251, -75.714194 45.382528, -79.388111 43.662972)))"
							mapPoints = arr[i][index].slice(arr[i][index].indexOf("(((") + 3, arr[i][index].indexOf(")))")).split(")), ((");
					}
					
					// graphic array containing ESRI Graphic objects for POINT features previously created above
					if (feature != "POINT")
					{
						//initialize an array of ESRI Web Mercator MapPoints (automatically projects WGS84 (EPSG:4326) geographic coordinates to Web Mercator (ESRI:102100) XY coordinates)
						var mapPoint:Array = [];
						
						// iterate through the array created above
						for (j=0; j<mapPoints.length; j++)
						{
							// create geometry parameter for ESRI Graphic constructor
							// previous SWITCH operation created either an array (TRUE) or an array of arrays (FALSE) depending upon the geometry type
							if (feature == "MULTIPOINT" || feature == "LINESTRING" || feature == "POLYGON")
							{
								// determine Lng and Lat values, instantiate MapPoint and add to array of MapPoints
								LngLat = mapPoints[j].split(" ");
								mapPoint.push(new WebMercatorMapPoint(parseFloat(LngLat[0]), parseFloat(LngLat[1])));
							}
							else
							{
								// split array of arrays into individual LINESTRING or POLYGON features
								var point:Array = mapPoints[j].split(", ");
								
								// iterate through each individual feature
								for (var k:int=0; k<point.length; k++)
								{
									// determine Lng and Lat values, instantiate MapPoint and add to array of MapPoints
									LngLat = point[k].split(" ");
									mapPoint.push(new WebMercatorMapPoint(parseFloat(LngLat[0]), parseFloat(LngLat[1])));
								}
								
								switch(feature)
								{
									case "MULTILINESTRING":
										// add feature to graphic array containing ESRI Graphic objects instantiated with Graphic constructor
										// EPSG spatial reference 3857 is equivalent to ESRI spatial reference 102100 - use either one interchangeably
										graphic.push(new Graphic(new Polyline([mapPoint], new SpatialReference(3857)), new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID, 0xFF0000, 0.5, 2), attr));
										break;
									
									case "MULTIPOLYGON":
										graphic.push(new Graphic(new Polygon([mapPoint], new SpatialReference(3857)), new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID, 0xFF0000, 0.5), attr));
								}
								
								// re-initialize array of Web Mercator MapPoints
								mapPoint = [];
							}
						}
						
						// same operation as immediately above for the remaining geometry types
						if ((feature != "MULTILINESTRING") && (feature != "MULTIPOLYGON"))
						{
							switch(feature)
							{
								case "MULTIPOINT":
									graphic.push(new Graphic(new Multipoint(mapPoint, new SpatialReference(3857)), new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_DIAMOND, 10, 0xFF0000, 0.5), attr));
									break;
								
								case "LINESTRING":
									graphic.push(new Graphic(new Polyline([mapPoint], new SpatialReference(3857)), new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID, 0xFF0000, 0.5, 2), attr));
									break;
								
								case "POLYGON":
									graphic.push(new Graphic(new Polygon([mapPoint], new SpatialReference(3857)), new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID, 0xFF0000, 0.5), attr));
							}
						}
					}
				}
			}
			else
			{
				graphic = null;
			}
			// return array of ESRI Graphic objects
			return graphic;
		}
		
		// return geometry (feature) type
		public static function getGeometry():String
		{
			// convert MS SQL SERVER spatial datatype name convention into ESRI ArcGIS Flex API Geometry sub-class name convention
			switch(feature)
			{
				case "POINT":
					feature = "MapPoint";
					break;
				
				case "MULTIPOINT":
					feature = "Multipoint";
					break;
				
				case "LINESTRING":
					feature = "Polyline";
					break;
				
				case "MULTILINESTRING":
					feature = "Polyline";
					break;
				
				case "POLYGON":
					feature = "Polygon";
					break;
				
				case "MULTIPOLYGON":
					feature = "Polygon";
			}
			
			return feature;
		}
	}
}
