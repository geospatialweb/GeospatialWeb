GeospatialWeb
=============

This is the source code for my portfolio website that showcases some preliminary work for an online Masters GIS thesis at Penn State University, if I ever get around to committing to it! Unlikely, since I'm having too much fun taking wicked courses such as complexity science and dynamical systems from top USA universities for free as noted in my LinkedIn profile located at http://www.linkedin.com/in/geospatialweb. I'm big on continuous learning and distance learning fits the bill nicely.

I have assembled an ongoing database of hourly air quality readings for 40 reporting stations throughout Ontario since January 1, 2007. Given the Ontario Ministry of Environment does not provide API data access, I have to screen scrape the current readings off their website and parse the XHTML using E4X. Works great until they change the coding of the web pages! It has only happened once, so I can't complain. Well, it finally happened recently and I don't have time right now to re-write the screen scraping code so display of hourly air quality readings is non-functional presently.

There is alot of REST and AJAX going on here. The MOE website plus the Google Elevation API and Google Geocoder API. And integration with ArcGIS Server geoprocessing services with ArcPY back-end producing and returning PDF reports on demand.

I wrote my first PHP classes as a learning experience. And I also wrote my first static method in Flex that accepts an array collection of data with the geographic reference expressed as an OGC-compliant datatype and returns an array of ESRI Graphic objects that can be added to a map layer - since the ESRI APIs cannot work with spatial datatypes and methods such as WKT.

The trick here is that one can accept any data without knowing the name of the shape field containing the spatial data. Object introspection is employed to determine the name of the shape field and then proceeds to convert WKT into ESRI Graphics. This is a very useful class and it is called SQLFeature.as in the src/components directory. It is called from AQI.mxml in the src/widgets directory.

In src/widgets directory, there is also a test widget that uses an AMF remote object connection to the SQL database - in this case using a Java harness (that I did not write) - that passes spatial queries and accepts an array collection of spatial data to be converted into ESRI Graphics using the SQLFeature.getGraphic() static method as noted above.

There is something called "Diagnostic Surface Vector Analysis" that I conjured up since it returned 0 hits in Google. If it works, I'm going to take out a patent. :) But I'm not quite sure what it will do just yet, so that is why I'm will be enrolling in the edX online linear algebra course from the University of Texas, Austin working with IPython notebooks of cutting-edge Python software libraries the professors are developing on their new supercomputer. I previously audited Pre-Calculus so I have a handle now on the trig. And most likely more calculus to come. I like math, but this is getting a bit much! So we'll see...

I won't get into it here, but my personal research entails converting data into sound. What if we can hear spatial patterns in the data that we cannot easily discern using traditional data analysis and visualization techniques? I believe everything in the universe is energy and all energy has a frequency. String theory.

So perhaps using frequency domain analysis and data sonification one can hear waveform patterns in spatially autocorrelated data, that to the naked eye appear meaningless, by eliminating all the "noise" in the data to discern "signature" beats, tempo, pitch and timbre, for example. Perhaps we can hear what we cannot see - because we are looking when we should be listening. Just an idea that intriques me.

To what end? Well, Doppler radar can give us maybe 15 minutes advance warning of an impending tornado and good luck if one lives in a nursing home like my mother. Or an avalanche, tsunami or earthquake. Maybe there are other ways to "predict" the unpredictable with higher degrees of precision and accuracy that can help save lives.

So last Fall, I took a free online music technology course from Georgia Tech and learned how to convert data into sound. The Python script is the scripts directory. I took a random month of hourly data from the air quality database for each reporting station and sonified the data using the EarSketch API for the REAPER digital audio workstation that we learned in class and incorporated the sound files into the website.

I haven't done much else to date but it is a good start. At least I know it can be done when at the outset I didn't know if it could be done. The mp3 collection is in the assets directory.

I have varied interests and varied skill sets. I love geospatial web development and that is why I do it for a living...
