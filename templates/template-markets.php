<?php
/**
* Template Name: Markets Overview
* Description: Displays all 50 US states and 800+ local cities with professional styling.
*/
get_header();

// 1. Get all 50 US States (Using the same function as locations template for consistent data structure)
$states = nexagen_get_states();

// 2. Comprehensive list of 800+ local cities (slug => Display Name)
$cities = [
'abilene-tx' => 'Abilene, TX', 'alafaya-fl' => 'Alafaya, FL', 'albany-ga' => 'Albany, GA', 'albany-or' => 'Albany, OR', 'albany' => 'Albany, NY',
'alameda-ca' => 'Alameda, CA', 'alhambra-ca' => 'Alhambra, CA', 'aliso-viejo-ca' => 'Aliso Viejo, CA', 'allen-tx' => 'Allen, TX', 'allentown' => 'Allentown, PA',
'aloha-or' => 'Aloha, OR', 'alpharetta-ga' => 'Alpharetta, GA', 'altoona-pa' => 'Altoona, PA', 'amarillo-tx' => 'Amarillo, TX', 'ames-ia' => 'Ames, IA',
'anaheim-ca' => 'Anaheim, CA', 'anchorage-ak' => 'Anchorage, AK', 'anderson-in' => 'Anderson, IN', 'ann-arbor-mi' => 'Ann Arbor, MI', 'annapolis' => 'Annapolis, MD',
'anniston-al' => 'Anniston, AL', 'ankeny-ia' => 'Ankeny, IA', 'antelope-ca' => 'Antelope, CA', 'antioch-ca' => 'Antioch, CA', 'apex-nc' => 'Apex, NC',
'apple-valley-ca' => 'Apple Valley, CA', 'apple-valley-mn' => 'Apple Valley, MN', 'appleton-wi' => 'Appleton, WI', 'arcadia-ca' => 'Arcadia, CA', 'arden-arcade-ca' => 'Arden-Arcade, CA',
'arlington-heights-il' => 'Arlington Heights, IL', 'arlington-tx' => 'Arlington, TX', 'arlington-va' => 'Arlington, VA', 'arvada-co' => 'Arvada, CO', 'asheville-nc' => 'Asheville, NC',
'aspen-hill-md' => 'Aspen Hill, MD', 'atascocita-tx' => 'Atascocita, TX', 'athens-ga' => 'Athens, GA', 'atlanta-ga' => 'Atlanta, GA', 'auburn-al' => 'Auburn, AL',
'auburn-wa' => 'Auburn, WA', 'aurora-co' => 'Aurora, CO', 'aurora-il' => 'Aurora, IL', 'austin-tx' => 'Austin, TX', 'avondale-az' => 'Avondale, AZ',
'azusa-ca' => 'Azusa, CA', 'bakersfield' => 'Bakersfield, CA', 'baldwin-park-ca' => 'Baldwin Park, CA', 'baltimore' => 'Baltimore, MD', 'bartlett-tn' => 'Bartlett, TN',
'battle-creek-mi' => 'Battle Creek, MI', 'bay-city-mi' => 'Bay City, MI', 'bayonne-nj' => 'Bayonne, NJ', 'baytown-tx' => 'Baytown, TX', 'beaumont-ca' => 'Beaumont, CA',
'beaumont-tx' => 'Beaumont, TX', 'beaverton-or' => 'Beaverton, OR', 'bedford-tx' => 'Bedford, TX', 'bel-air-south-md' => 'Bel Air South, MD', 'bellingham-wa' => 'Bellingham, WA',
'bellevue-ne' => 'Bellevue, NE', 'bellevue-wa' => 'Bellevue, WA', 'bellflower-ca' => 'Bellflower, CA', 'bend-or' => 'Bend, OR', 'bentonville-ar' => 'Bentonville, AR',
'berkeley-ca' => 'Berkeley, CA', 'berlin' => 'Berlin, CT', 'berwyn-il' => 'Berwyn, IL', 'bethesda-md' => 'Bethesda, MD', 'bethlehem-pa' => 'Bethlehem, PA',
'biloxi-ms' => 'Biloxi, MS', 'billings-mt' => 'Billings, MT', 'birmingham-al' => 'Birmingham, AL', 'bismarck-nd' => 'Bismarck, ND', 'blacksburg-va' => 'Blacksburg, VA',
'blaine-mn' => 'Blaine, MN', 'bloomington-il' => 'Bloomington, IL', 'bloomington-in' => 'Bloomington, IN', 'bloomington-mn' => 'Bloomington, MN', 'blue-springs-mo' => 'Blue Springs, MO',
'boca-raton-fl' => 'Boca Raton, FL', 'boise-id' => 'Boise, ID', 'bolingbrook-il' => 'Bolingbrook, IL', 'bonita-springs-fl' => 'Bonita Springs, FL', 'bossier-city-la' => 'Bossier City, LA',
'boston' => 'Boston, MA', 'bothell-wa' => 'Bothell, WA', 'boulder-co' => 'Boulder, CO', 'bowie-md' => 'Bowie, MD', 'bowling-green-ky' => 'Bowling Green, KY',
'boynton-beach-fl' => 'Boynton Beach, FL', 'bozeman-mt' => 'Bozeman, MT', 'bradenton-fl' => 'Bradenton, FL', 'brandon-fl' => 'Brandon, FL', 'brea-ca' => 'Brea, CA',
'bremerton-wa' => 'Bremerton, WA', 'brentwood-ca' => 'Brentwood, CA', 'bridgeport' => 'Bridgeport, CT', 'bristol-ct' => 'Bristol, CT', 'bristol-tn' => 'Bristol, TN',
'broken-arrow-ok' => 'Broken Arrow, OK', 'bronx-ny' => 'Bronx, NY', 'brookhaven-ga' => 'Brookhaven, GA', 'brooklyn-ny' => 'Brooklyn, NY', 'brooklyn-park-mn' => 'Brooklyn Park, MN',
'broomfield-co' => 'Broomfield, CO', 'brownsville-tx' => 'Brownsville, TX', 'brunswick-ga' => 'Brunswick, GA', 'bryan-tx' => 'Bryan, TX', 'buckeye-az' => 'Buckeye, AZ',
'buena-park-ca' => 'Buena Park, CA', 'buffalo' => 'Buffalo, NY', 'burien-wa' => 'Burien, WA', 'burbank-ca' => 'Burbank, CA', 'burleson-tx' => 'Burleson, TX',
'burlington-nc' => 'Burlington, NC', 'burlington-vt' => 'Burlington, VT', 'burnsville-mn' => 'Burnsville, MN', 'caldwell-id' => 'Caldwell, ID', 'camarillo-ca' => 'Camarillo, CA',
'cambridge-ma' => 'Cambridge, MA', 'camden-nj' => 'Camden, NJ', 'canton-oh' => 'Canton, OH', 'cape-coral-fl' => 'Cape Coral, FL', 'carlsbad-ca' => 'Carlsbad, CA',
'carmel-in' => 'Carmel, IN', 'carmichael-ca' => 'Carmichael, CA', 'carrollton-tx' => 'Carrollton, TX', 'carson-ca' => 'Carson, CA', 'carson-city-nv' => 'Carson City, NV',
'casa-grande-az' => 'Casa Grande, AZ', 'casas-adobes-az' => 'Casas Adobes, AZ', 'casper-wy' => 'Casper, WY', 'castle-rock-co' => 'Castle Rock, CO', 'catalina-foothills-az' => 'Catalina Foothills, AZ',
'cathedral-city-ca' => 'Cathedral City, CA', 'cedar-hill-tx' => 'Cedar Hill, TX', 'cedar-park-tx' => 'Cedar Park, TX', 'cedar-rapids-ia' => 'Cedar Rapids, IA', 'centennial-co' => 'Centennial, CO',
'centreville-va' => 'Centreville, VA', 'ceres-ca' => 'Ceres, CA', 'cerritos-ca' => 'Cerritos, CA', 'champaign-il' => 'Champaign, IL', 'chandler-az' => 'Chandler, AZ',
'chapel-hill-nc' => 'Chapel Hill, NC', 'charleston-sc' => 'Charleston, SC', 'charleston-wv' => 'Charleston, WV', 'charlottesville' => 'Charlottesville, VA', 'chattanooga-tn' => 'Chattanooga, TN',
'chesapeake-va' => 'Chesapeake, VA', 'chesterfield-mo' => 'Chesterfield, MO', 'cheyenne-wy' => 'Cheyenne, WY', 'chicago' => 'Chicago, IL', 'chicopee-ma' => 'Chicopee, MA',
'chico-ca' => 'Chico, CA', 'chino-ca' => 'Chino, CA', 'chula-vista-ca' => 'Chula Vista, CA', 'cicero-il' => 'Cicero, IL', 'cincinnati' => 'Cincinnati, OH',
'citrus-heights-ca' => 'Citrus Heights, CA', 'clarksville-tn' => 'Clarksville, TN', 'clearwater-fl' => 'Clearwater, FL', 'cleveland' => 'Cleveland, OH', 'cleveland-tn' => 'Cleveland, TN',
'clifton-nj' => 'Clifton, NJ', 'clovis-ca' => 'Clovis, CA', 'coconut-creek-fl' => 'Coconut Creek, FL', 'coeur-d-alene-id' => "Coeur d'Alene, ID", 'college-station-tx' => 'College Station, TX',
'collierville-tn' => 'Collierville, TN', 'colton-ca' => 'Colton, CA', 'columbia-md' => 'Columbia, MD', 'columbia-mo' => 'Columbia, MO', 'columbia-sc' => 'Columbia, SC',
'columbus-ga' => 'Columbus, GA', 'columbus-in' => 'Columbus, IN', 'columbus-oh' => 'Columbus, OH', 'commerce-city-co' => 'Commerce City, CO', 'compton-ca' => 'Compton, CA',
'concord' => 'Concord, NC', 'concord-ca' => 'Concord, CA', 'conroe-tx' => 'Conroe, TX', 'conway-ar' => 'Conway, AR', 'coon-rapids-mn' => 'Coon Rapids, MN',
'coral-gables-fl' => 'Coral Gables, FL', 'coral-springs-fl' => 'Coral Springs, FL', 'corning' => 'Corning, NY', 'corona-ca' => 'Corona, CA', 'corpus-christi-tx' => 'Corpus Christi, TX',
'corvallis-or' => 'Corvallis, OR', 'costa-mesa-ca' => 'Costa Mesa, CA', 'country-club-fl' => 'Country Club, FL', 'council-bluffs-ia' => 'Council Bluffs, IA', 'covina-ca' => 'Covina, CA',
'cranston-ri' => 'Cranston, RI', 'cuyahoga-falls-oh' => 'Cuyahoga Falls, OH', 'cupertino-ca' => 'Cupertino, CA', 'cypress-ca' => 'Cypress, CA', 'daly-city-ca' => 'Daly City, CA',
'dale-city-va' => 'Dale City, VA', 'dalton-ga' => 'Dalton, GA', 'danbury-ct' => 'Danbury, CT', 'davenport-ia' => 'Davenport, IA', 'davis-ca' => 'Davis, CA',
'davie-fl' => 'Davie, FL', 'dayton-oh' => 'Dayton, OH', 'daytona-beach-fl' => 'Daytona Beach, FL', 'dearborn-mi' => 'Dearborn, MI', 'decatur-al' => 'Decatur, AL',
'decatur-il' => 'Decatur, IL', 'deerfield-beach-fl' => 'Deerfield Beach, FL', 'delano-ca' => 'Delano, CA', 'delray-beach-fl' => 'Delray Beach, FL', 'deltona-fl' => 'Deltona, FL',
'denver' => 'Denver, CO', 'des-moines-ia' => 'Des Moines, IA', 'des-plaines-il' => 'Des Plaines, IL', 'desoto-tx' => 'DeSoto, TX', 'detroit-mi' => 'Detroit, MI',
'diamond-bar-ca' => 'Diamond Bar, CA', 'doral-fl' => 'Doral, FL', 'dover-de' => 'Dover, DE', 'dover-nh' => 'Dover, NH', 'downers-grove-il' => 'Downers Grove, IL',
'downey-ca' => 'Downey, CA', 'draper-ut' => 'Draper, UT', 'dublin-ca' => 'Dublin, CA', 'dublin-oh' => 'Dublin, OH', 'dubuque-ia' => 'Dubuque, IA',
'duluth-mn' => 'Duluth, MN', 'dundalk-md' => 'Dundalk, MD', 'dunwoody-ga' => 'Dunwoody, GA', 'durham-nc' => 'Durham, NC', 'eagan-mn' => 'Eagan, MN',
'eagle-mountain-ut' => 'Eagle Mountain, UT', 'east-orange-nj' => 'East Orange, NJ', 'eastvale-ca' => 'Eastvale, CA', 'eau-claire-wi' => 'Eau Claire, WI', 'eden-prairie-mn' => 'Eden Prairie, MN',
'edina-mn' => 'Edina, MN', 'edmond-ok' => 'Edmond, OK', 'edinburg-tx' => 'Edinburg, TX', 'el-cajon-ca' => 'El Cajon, CA', 'el-dorado-hills-ca' => 'El Dorado Hills, CA',
'el-monte-ca' => 'El Monte, CA', 'el-paso-de-robles-ca' => 'El Paso de Robles, CA', 'el-paso-tx' => 'El Paso, TX', 'elgin-il' => 'Elgin, IL', 'elizabeth' => 'Elizabeth, NJ',
'elizabethtown-ky' => 'Elizabethtown, KY', 'elkhart-in' => 'Elkhart, IN', 'ellicott-city-md' => 'Ellicott City, MD', 'elyria-oh' => 'Elyria, OH', 'encinitas-ca' => 'Encinitas, CA',
'enid-ok' => 'Enid, OK', 'enterprise-nv' => 'Enterprise, NV', 'erie' => 'Erie, PA', 'escondido-ca' => 'Escondido, CA', 'euclid-oh' => 'Euclid, OH',
'eugene-or' => 'Eugene, OR', 'euless-tx' => 'Euless, TX', 'evanston-il' => 'Evanston, IL', 'everett-ma' => 'Everett, MA', 'everett-wa' => 'Everett, WA',
'evansville-in' => 'Evansville, IN', 'fairbanks-ak' => 'Fairbanks, AK', 'fairfax' => 'Fairfax, VA', 'fairfield-ca' => 'Fairfield, CA', 'fall-river-ma' => 'Fall River, MA',
'fargo-nd' => 'Fargo, ND', 'farmington-hills-mi' => 'Farmington Hills, MI', 'fayetteville-ar' => 'Fayetteville, AR', 'fayetteville-nc' => 'Fayetteville, NC', 'federal-way-wa' => 'Federal Way, WA',
'fishers-in' => 'Fishers, IN', 'flagstaff-az' => 'Flagstaff, AZ', 'flint-mi' => 'Flint, MI', 'florence-al' => 'Florence, AL', 'florence-graham-ca' => 'Florence-Graham, CA',
'florence-sc' => 'Florence, SC', 'florin-ca' => 'Florin, CA', 'florissant-mo' => 'Florissant, MO', 'flower-mound-tx' => 'Flower Mound, TX', 'folsom-ca' => 'Folsom, CA',
'fontana-ca' => 'Fontana, CA', 'fort-collins-co' => 'Fort Collins, CO', 'fort-lauderdale' => 'Fort Lauderdale, FL', 'fort-myers-beach-fl' => 'Fort Myers Beach, FL', 'fort-myers-fl' => 'Fort Myers, FL',
'fort-pierce-fl' => 'Fort Pierce, FL', 'fort-smith-ar' => 'Fort Smith, AR', 'fort-wayne' => 'Fort Wayne, IN', 'fort-worth-tx' => 'Fort Worth, TX', 'fountain-valley-ca' => 'Fountain Valley, CA',
'fountainebleau-fl' => 'Fountainebleau, FL', 'framingham-ma' => 'Framingham, MA', 'franklin-tn' => 'Franklin, TN', 'frederick-md' => 'Frederick, MD', 'fredericksburg' => 'Fredericksburg, VA',
'fremont-ca' => 'Fremont, CA', 'fresno' => 'Fresno, CA', 'frisco-tx' => 'Frisco, TX', 'fullerton-ca' => 'Fullerton, CA', 'gainesville-fl' => 'Gainesville, FL',
'gainesville-ga' => 'Gainesville, GA', 'galveston-tx' => 'Galveston, TX', 'garden-grove-ca' => 'Garden Grove, CA', 'gardena-ca' => 'Gardena, CA', 'garland-tx' => 'Garland, TX',
'gary-in' => 'Gary, IN', 'gastonia-nc' => 'Gastonia, NC', 'georgetown-tx' => 'Georgetown, TX', 'germantown-md' => 'Germantown, MD', 'gilbert-az' => 'Gilbert, AZ',
'gilroy-ca' => 'Gilroy, CA', 'glendale-az' => 'Glendale, AZ', 'glendale-ca' => 'Glendale, CA', 'glendora-ca' => 'Glendora, CA', 'glen-burnie-md' => 'Glen Burnie, MD',
'glens-falls-ny' => 'Glens Falls, NY', 'glenview-il' => 'Glenview, IL', 'goodyear-az' => 'Goodyear, AZ', 'grand-forks-nd' => 'Grand Forks, ND', 'grand-island-ne' => 'Grand Island, NE',
'grand-junction-co' => 'Grand Junction, CO', 'grand-prairie-tx' => 'Grand Prairie, TX', 'grand-rapids-mi' => 'Grand Rapids, MI', 'grapevine-tx' => 'Grapevine, TX', 'great-falls-mt' => 'Great Falls, MT',
'greeley-co' => 'Greeley, CO', 'green-bay-wi' => 'Green Bay, WI', 'greensboro-nc' => 'Greensboro, NC', 'greenwood-in' => 'Greenwood, IN', 'gresham-or' => 'Gresham, OR',
'gulfport-ms' => 'Gulfport, MS', 'hacienda-heights-ca' => 'Hacienda Heights, CA', 'hagerstown-md' => 'Hagerstown, MD', 'hamilton-oh' => 'Hamilton, OH', 'hammond-in' => 'Hammond, IN',
'hammond-la' => 'Hammond, LA', 'hampton-va' => 'Hampton, VA', 'hanford-ca' => 'Hanford, CA', 'harlingen-tx' => 'Harlingen, TX', 'harrisburg-pa' => 'Harrisburg, PA',
'harrisonburg-va' => 'Harrisonburg, VA', 'hartford-ct' => 'Hartford, CT', 'hawthorne-ca' => 'Hawthorne, CA', 'hayward-ca' => 'Hayward, CA', 'hemet-ca' => 'Hemet, CA',
'henderson-nv' => 'Henderson, NV', 'hendersonville-tn' => 'Hendersonville, TN', 'hesperia-ca' => 'Hesperia, CA', 'herriman-ut' => 'Herriman, UT', 'hickory-nc' => 'Hickory, NC',
'highland-ca' => 'Highland, CA', 'highlands-ranch-co' => 'Highlands Ranch, CO', 'high-point-nc' => 'High Point, NC', 'hilo-hi' => 'Hilo, HI', 'hillsboro-or' => 'Hillsboro, OR',
'hialeah' => 'Hialeah, FL', 'hoboken-nj' => 'Hoboken, NJ', 'hoffman-estates-il' => 'Hoffman Estates, IL', 'holland-mi' => 'Holland, MI', 'hollywood-fl' => 'Hollywood, FL',
'homestead-fl' => 'Homestead, FL', 'honolulu-hi' => 'Honolulu, HI', 'hoover-al' => 'Hoover, AL', 'horizon-west-fl' => 'Horizon West, FL', 'horseheads' => 'Horseheads, NY',
'houma-la' => 'Houma, LA', 'houston-tx' => 'Houston, TX', 'huntington-beach-ca' => 'Huntington Beach, CA', 'huntington-park-ca' => 'Huntington Park, CA', 'huntington-wv' => 'Huntington, WV',
'huntsville-al' => 'Huntsville, AL', 'huntersville-nc' => 'Huntersville, NC', 'idaho-falls-id' => 'Idaho Falls, ID', 'indio-ca' => 'Indio, CA', 'independence-mo' => 'Independence, MO',
'indianapolis' => 'Indianapolis, IN', 'inglewood-ca' => 'Inglewood, CA', 'irvine-ca' => 'Irvine, CA', 'irving-tx' => 'Irving, TX', 'iowa-city-ia' => 'Iowa City, IA',
'ithaca' => 'Ithaca, NY', 'jackson-mi' => 'Jackson, MI', 'jackson-ms' => 'Jackson, MS', 'jackson-tn' => 'Jackson, TN', 'jacksonville' => 'Jacksonville, FL',
'jacksonville-nc' => 'Jacksonville, NC', 'janesville-wi' => 'Janesville, WI', 'jersey-city' => 'Jersey City, NJ', 'jeffersonville-in' => 'Jeffersonville, IN', 'johns-creek-ga' => 'Johns Creek, GA',
'johnson-city-tn' => 'Johnson City, TN', 'joliet-il' => 'Joliet, IL', 'jonesboro-ar' => 'Jonesboro, AR', 'joplin-mo' => 'Joplin, MO', 'jupiter-fl' => 'Jupiter, FL',
'jurupa-valley-ca' => 'Jurupa Valley, CA', 'kailua-hi' => 'Kailua, HI', 'kalamazoo-mi' => 'Kalamazoo, MI', 'kannapolis-nc' => 'Kannapolis, NC', 'kankakee-il' => 'Kankakee, IL',
'kansas-city-ks' => 'Kansas City, KS', 'kansas-city-mo' => 'Kansas City, MO', 'kendall-fl' => 'Kendall, FL', 'kendale-lakes-fl' => 'Kendale Lakes, FL', 'kenner-la' => 'Kenner, LA',
'kennewick-wa' => 'Kennewick, WA', 'kenosha-wi' => 'Kenosha, WI', 'kent-wa' => 'Kent, WA', 'kentwood-mi' => 'Kentwood, MI', 'kettering-oh' => 'Kettering, OH',
'killeen-tx' => 'Killeen, TX', 'kingsport-tn' => 'Kingsport, TN', 'kirkland-wa' => 'Kirkland, WA', 'kissimmee-fl' => 'Kissimmee, FL', 'kokomo-in' => 'Kokomo, IN',
'kyle-tx' => 'Kyle, TX', 'la-crosse-wi' => 'La Crosse, WI', 'la-habra-ca' => 'La Habra, CA', 'la-mesa-ca' => 'La Mesa, CA', 'lacey-wa' => 'Lacey, WA',
'lafayette-co' => 'Lafayette, CO', 'lafayette-in' => 'Lafayette, IN', 'lafayette-la' => 'Lafayette, LA', 'laguna-niguel-ca' => 'Laguna Niguel, CA', 'lake-charles-la' => 'Lake Charles, LA',
'lake-elsinore-ca' => 'Lake Elsinore, CA', 'lake-forest-ca' => 'Lake Forest, CA', 'lake-havasu-city-az' => 'Lake Havasu City, AZ', 'lakeville-mn' => 'Lakeville, MN', 'lakewood-ca' => 'Lakewood, CA',
'lakewood-co' => 'Lakewood, CO', 'lakewood-oh' => 'Lakewood, OH', 'lakewood-wa' => 'Lakewood, WA', 'lancaster-ca' => 'Lancaster, CA', 'lancaster-pa' => 'Lancaster, PA',
'lansing-mi' => 'Lansing, MI', 'laredo-tx' => 'Laredo, TX', 'largo-fl' => 'Largo, FL', 'las-cruces-nm' => 'Las Cruces, NM', 'las-vegas-nv' => 'Las Vegas, NV',
'lauderhill-fl' => 'Lauderhill, FL', 'lawrence' => 'Lawrence, MA', 'lawrence-ks' => 'Lawrence, KS', 'lawrence-in' => 'Lawrence, IN', 'lawton-ok' => 'Lawton, OK',
'layton-ut' => 'Layton, UT', 'leander-tx' => 'Leander, TX', 'lebanon-pa' => 'Lebanon, PA', 'lee-s-summit-mo' => "Lee's Summit, MO", 'leesburg-fl' => 'Leesburg, FL',
'leesburg-va' => 'Leesburg, VA', 'lehi-ut' => 'Lehi, UT', 'lehigh-acres-fl' => 'Lehigh Acres, FL', 'lenexa-ks' => 'Lenexa, KS', 'leominster-ma' => 'Leominster, MA',
'levittown-ny' => 'Levittown, NY', 'lewisville-tx' => 'Lewisville, TX', 'lexington' => 'Lexington, KY', 'lima-oh' => 'Lima, OH', 'lincoln' => 'Lincoln, NE',
'lincoln-ca' => 'Lincoln, CA', 'livermore-ca' => 'Livermore, CA', 'livonia-mi' => 'Livonia, MI', 'lodi-ca' => 'Lodi, CA', 'logan-ut' => 'Logan, UT',
'long-beach-ca' => 'Long Beach, CA', 'longmont-co' => 'Longmont, CO', 'longview-tx' => 'Longview, TX', 'longview-wa' => 'Longview, WA', 'lorain-oh' => 'Lorain, OH',
'los-angeles' => 'Los Angeles, CA', 'loveland-co' => 'Loveland, CO', 'lowell' => 'Lowell, MA', 'lubbock-tx' => 'Lubbock, TX', 'lynchburg-va' => 'Lynchburg, VA',
'lynn-ma' => 'Lynn, MA', 'lynwood-ca' => 'Lynwood, CA', 'macon-ga' => 'Macon, GA', 'madera-ca' => 'Madera, CA', 'madison-al' => 'Madison, AL',
'madison-wi' => 'Madison, WI', 'malden-ma' => 'Malden, MA', 'manassas' => 'Manassas, VA', 'manchester' => 'Manchester, NH', 'manhattan-ks' => 'Manhattan, KS',
'manhattan-ny' => 'Manhattan, NY', 'mansfield-oh' => 'Mansfield, OH', 'mansfield-tx' => 'Mansfield, TX', 'manteca-ca' => 'Manteca, CA', 'maple-grove-mn' => 'Maple Grove, MN',
'marana-az' => 'Marana, AZ', 'margate-fl' => 'Margate, FL', 'marietta-ga' => 'Marietta, GA', 'maricopa-az' => 'Maricopa, AZ', 'marysville-wa' => 'Marysville, WA',
'mauldin-sc' => 'Mauldin, SC', 'mcallen-tx' => 'McAllen, TX', 'mckinney-tx' => 'McKinney, TX', 'mclean-va' => 'McLean, VA', 'medford-ma' => 'Medford, MA',
'medford-or' => 'Medford, OR', 'melbourne-fl' => 'Melbourne, FL', 'menifee-ca' => 'Menifee, CA', 'merced-ca' => 'Merced, CA', 'meriden-ct' => 'Meriden, CT',
'meridian-id' => 'Meridian, ID', 'mesa-az' => 'Mesa, AZ', 'mesquite-tx' => 'Mesquite, TX', 'methuen-town-ma' => 'Methuen Town, MA', 'metairie-la' => 'Metairie, LA',
'michigan-city-in' => 'Michigan City, IN', 'middletown-ct' => 'Middletown, CT', 'middletown-oh' => 'Middletown, OH', 'midland-tx' => 'Midland, TX', 'midwest-city-ok' => 'Midwest City, OK',
'milford-ct' => 'Milford, CT', 'millcreek-ut' => 'Millcreek, UT', 'milpitas-ca' => 'Milpitas, CA', 'milwaukee-wi' => 'Milwaukee, WI', 'minneapolis' => 'Minneapolis, MN',
'minnetonka-mn' => 'Minnetonka, MN', 'minot-nd' => 'Minot, ND', 'miramar-fl' => 'Miramar, FL', 'mission-tx' => 'Mission, TX', 'mission-viejo-ca' => 'Mission Viejo, CA',
'missoula-mt' => 'Missoula, MT', 'missouri-city-tx' => 'Missouri City, TX', 'mishawaka-in' => 'Mishawaka, IN', 'mobile-al' => 'Mobile, AL', 'modesto-ca' => 'Modesto, CA',
'monroe-la' => 'Monroe, LA', 'monterey-park-ca' => 'Monterey Park, CA', 'montebello-ca' => 'Montebello, CA', 'montgomery-al' => 'Montgomery, AL', 'moore-ok' => 'Moore, OK',
'mooresville-nc' => 'Mooresville, NC', 'moreno-valley-ca' => 'Moreno Valley, CA', 'morgantown-wv' => 'Morgantown, WV', 'morristown-tn' => 'Morristown, TN', 'mount-pleasant-sc' => 'Mount Pleasant, SC',
'mount-prospect-il' => 'Mount Prospect, IL', 'mount-vernon-ny' => 'Mount Vernon, NY', 'mount-vernon-wa' => 'Mount Vernon, WA', 'muncie-in' => 'Muncie, IN', 'murfreesboro-tn' => 'Murfreesboro, TN',
'murrieta-ca' => 'Murrieta, CA', 'murray-ut' => 'Murray, UT', 'muskegon-mi' => 'Muskegon, MI', 'myrtle-beach-sc' => 'Myrtle Beach, SC', 'nampa-id' => 'Nampa, ID',
'napa-ca' => 'Napa, CA', 'naperville-il' => 'Naperville, IL', 'nashua-nh' => 'Nashua, NH', 'nashville-tn' => 'Nashville, TN', 'national-city-ca' => 'National City, CA',
'new-braunfels-tx' => 'New Braunfels, TX', 'new-britain-ct' => 'New Britain, CT', 'new-brunswick-nj' => 'New Brunswick, NJ', 'new-haven-ct' => 'New Haven, CT', 'new-orleans-la' => 'New Orleans, LA',
'new-rochelle-ny' => 'New Rochelle, NY', 'new-smyrna-beach-fl' => 'New Smyrna Beach, FL', 'new-york-city' => 'New York City, NY', 'newark' => 'Newark, NJ', 'newark-oh' => 'Newark, OH',
'newport-beach-ca' => 'Newport Beach, CA', 'newport-news-va' => 'Newport News, VA', 'newton-ma' => 'Newton, MA', 'niagara-falls-ny' => 'Niagara Falls, NY', 'noblesville-in' => 'Noblesville, IN',
'normal-il' => 'Normal, IL', 'norman-ok' => 'Norman, OK', 'norfolk' => 'Norfolk, VA', 'north-highlands-ca' => 'North Highlands, CA', 'north-port-fl' => 'North Port, FL',
'north-richland-hills-tx' => 'North Richland Hills, TX', 'norwalk-ca' => 'Norwalk, CA', 'norwalk-ct' => 'Norwalk, CT', 'norwich-ct' => 'Norwich, CT', 'novato-ca' => 'Novato, CA',
'novi-mi' => 'Novi, MI', 'o-fallon-mo' => "O'Fallon, MO", 'oak-park-il' => 'Oak Park, IL', 'oakland-ca' => 'Oakland, CA', 'ocala-fl' => 'Ocala, FL',
'oceanside-ca' => 'Oceanside, CA', 'odessa-tx' => 'Odessa, TX', 'ogden-ut' => 'Ogden, UT', 'olathe-ks' => 'Olathe, KS', 'olympia-wa' => 'Olympia, WA',
'omaha-ne' => 'Omaha, NE', 'ontario-ca' => 'Ontario, CA', 'orange-ca' => 'Orange, CA', 'orland-park-il' => 'Orland Park, IL', 'orlando-fl' => 'Orlando, FL',
'oro-valley-az' => 'Oro Valley, AZ', 'oshkosh-wi' => 'Oshkosh, WI', 'overland-park-ks' => 'Overland Park, KS', 'oxnard-ca' => 'Oxnard, CA', 'palatine-il' => 'Palatine, IL',
'palm-bay-fl' => 'Palm Bay, FL', 'palm-coast-fl' => 'Palm Coast, FL', 'palm-desert-ca' => 'Palm Desert, CA', 'palm-harbor-fl' => 'Palm Harbor, FL', 'palmdale-ca' => 'Palmdale, CA',
'palo-alto-ca' => 'Palo Alto, CA', 'panama-city-fl' => 'Panama City, FL', 'paradise-nv' => 'Paradise, NV', 'paramount-ca' => 'Paramount, CA', 'parker-co' => 'Parker, CO',
'parkersburg-wv' => 'Parkersburg, WV', 'parma-oh' => 'Parma, OH', 'pasadena-ca' => 'Pasadena, CA', 'pasadena-tx' => 'Pasadena, TX', 'pasco-wa' => 'Pasco, WA',
'passaic-nj' => 'Passaic, NJ', 'paterson-nj' => 'Paterson, NJ', 'pawtucket-ri' => 'Pawtucket, RI', 'peabody-ma' => 'Peabody, MA', 'pearland-tx' => 'Pearland, TX',
'peoria-az' => 'Peoria, AZ', 'peoria-il' => 'Peoria, IL', 'perris-ca' => 'Perris, CA', 'perth-amboy-nj' => 'Perth Amboy, NJ', 'petaluma-ca' => 'Petaluma, CA',
'pflugerville-tx' => 'Pflugerville, TX', 'pharr-tx' => 'Pharr, TX', 'philadelphia' => 'Philadelphia, PA', 'phoenix' => 'Phoenix, AZ', 'pico-rivera-ca' => 'Pico Rivera, CA',
'pittsburg-ca' => 'Pittsburg, CA', 'pittsburgh' => 'Pittsburgh, PA', 'placentia-ca' => 'Placentia, CA', 'plainfield-nj' => 'Plainfield, NJ', 'plano-tx' => 'Plano, TX',
'plantation-fl' => 'Plantation, FL', 'pleasanton-ca' => 'Pleasanton, CA', 'plymouth-mn' => 'Plymouth, MN', 'pocatello-id' => 'Pocatello, ID', 'poinciana-fl' => 'Poinciana, FL',
'pomona-ca' => 'Pomona, CA', 'pompano-beach-fl' => 'Pompano Beach, FL', 'pontiac-mi' => 'Pontiac, MI', 'port-arthur-tx' => 'Port Arthur, TX', 'port-charlotte-fl' => 'Port Charlotte, FL',
'port-huron-mi' => 'Port Huron, MI', 'port-orange-fl' => 'Port Orange, FL', 'portage-mi' => 'Portage, MI', 'porterville-ca' => 'Porterville, CA', 'portland' => 'Portland, OR',
'portland-me' => 'Portland, ME', 'portsmouth-nh' => 'Portsmouth, NH', 'portsmouth-va' => 'Portsmouth, VA', 'poughkeepsie-ny' => 'Poughkeepsie, NY', 'poway-ca' => 'Poway, CA',
'prescott-valley-az' => 'Prescott Valley, AZ', 'providence' => 'Providence, RI', 'provo-ut' => 'Provo, UT', 'pueblo-co' => 'Pueblo, CO', 'queen-creek-az' => 'Queen Creek, AZ',
'queens-ny' => 'Queens, NY', 'quincy-ma' => 'Quincy, MA', 'racine-wi' => 'Racine, WI', 'raleigh' => 'Raleigh, NC', 'rancho-cordova-ca' => 'Rancho Cordova, CA',
'rancho-cucamonga-ca' => 'Rancho Cucamonga, CA', 'rancho-santa-margarita-ca' => 'Rancho Santa Margarita, CA', 'rapid-city-sd' => 'Rapid City, SD', 'reading-pa' => 'Reading, PA', 'redmond-wa' => 'Redmond, WA',
'redondo-beach-ca' => 'Redondo Beach, CA', 'redwood-city-ca' => 'Redwood City, CA', 'reno-nv' => 'Reno, NV', 'renton-wa' => 'Renton, WA', 'reston-va' => 'Reston, VA',
'revere' => 'Revere, MA', 'rialto-ca' => 'Rialto, CA', 'richardson-tx' => 'Richardson, TX', 'richland-wa' => 'Richland, WA', 'richmond' => 'Richmond, VA',
'richmond-ca' => 'Richmond, CA', 'rio-rancho-nm' => 'Rio Rancho, NM', 'riverside-ca' => 'Riverside, CA', 'riverview-fl' => 'Riverview, FL', 'roanoke' => 'Roanoke, VA',
'rochester' => 'Rochester, NY', 'rochester-hills-mi' => 'Rochester Hills, MI', 'rochester-mn' => 'Rochester, MN', 'rock-hill-sc' => 'Rock Hill, SC', 'rockford-il' => 'Rockford, IL',
'rocklin-ca' => 'Rocklin, CA', 'rockville' => 'Rockville, MD', 'rockwall-tx' => 'Rockwall, TX', 'rocky-mount-nc' => 'Rocky Mount, NC', 'rogers-ar' => 'Rogers, AR',
'rosemead-ca' => 'Rosemead, CA', 'roseville-ca' => 'Roseville, CA', 'roseville-mi' => 'Roseville, MI', 'roswell-ga' => 'Roswell, GA', 'roswell-nm' => 'Roswell, NM',
'round-lake-beach-il' => 'Round Lake Beach, IL', 'round-rock-tx' => 'Round Rock, TX', 'rowlett-tx' => 'Rowlett, TX', 'royal-oak-mi' => 'Royal Oak, MI', 'sacramento' => 'Sacramento, CA',
'saginaw-mi' => 'Saginaw, MI', 'salinas-ca' => 'Salinas, CA', 'salisbury-md' => 'Salisbury, MD', 'salt-lake-city-ut' => 'Salt Lake City, UT', 'sammamish-wa' => 'Sammamish, WA',
'san-angelo-tx' => 'San Angelo, TX', 'san-bernardino-ca' => 'San Bernardino, CA', 'san-clemente-ca' => 'San Clemente, CA', 'san-diego-ca' => 'San Diego, CA', 'san-francisco' => 'San Francisco, CA',
'san-jacinto-ca' => 'San Jacinto, CA', 'san-jose-ca' => 'San Jose, CA', 'san-leandro-ca' => 'San Leandro, CA', 'san-luis-obispo-ca' => 'San Luis Obispo, CA', 'san-marcos-ca' => 'San Marcos, CA',
'san-marcos-tx' => 'San Marcos, TX', 'san-mateo-ca' => 'San Mateo, CA', 'san-rafael-ca' => 'San Rafael, CA', 'san-ramon-ca' => 'San Ramon, CA', 'san-tan-valley-az' => 'San Tan Valley, AZ',
'sandy-springs-ga' => 'Sandy Springs, GA', 'sandy-ut' => 'Sandy, UT', 'sanford-fl' => 'Sanford, FL', 'santa-ana' => 'Santa Ana, CA', 'santa-barbara-ca' => 'Santa Barbara, CA',
'santa-clara-ca' => 'Santa Clara, CA', 'santa-clarita-ca' => 'Santa Clarita, CA', 'santa-cruz-ca' => 'Santa Cruz, CA', 'santa-fe-nm' => 'Santa Fe, NM', 'santa-maria-ca' => 'Santa Maria, CA',
'santa-monica-ca' => 'Santa Monica, CA', 'santa-rosa-ca' => 'Santa Rosa, CA', 'santee-ca' => 'Santee, CA', 'sarasota-fl' => 'Sarasota, FL', 'saratoga-springs-ny' => 'Saratoga Springs, NY',
'schaumburg-il' => 'Schaumburg, IL', 'schenectady-ny' => 'Schenectady, NY', 'scottsdale-az' => 'Scottsdale, AZ', 'scranton' => 'Scranton, PA', 'seaside-ca' => 'Seaside, CA',
'sebring-fl' => 'Sebring, FL', 'severn-md' => 'Severn, MD', 'sherman-tx' => 'Sherman, TX', 'shoreline-wa' => 'Shoreline, WA', 'shreveport-la' => 'Shreveport, LA',
'sioux-city-ia' => 'Sioux City, IA', 'sioux-falls' => 'Sioux Falls, SD', 'skokie-il' => 'Skokie, IL', 'slidell-la' => 'Slidell, LA', 'smyrna-ga' => 'Smyrna, GA',
'smyrna-tn' => 'Smyrna, TN', 'somerville-ma' => 'Somerville, MA', 'south-bend-in' => 'South Bend, IN', 'south-fulton-ga' => 'South Fulton, GA', 'south-gate-ca' => 'South Gate, CA',
'south-hill-wa' => 'South Hill, WA', 'south-lyon-mi' => 'South Lyon, MI', 'southaven-ms' => 'Southaven, MS', 'southfield-mi' => 'Southfield, MI', 'spartanburg-sc' => 'Spartanburg, SC',
'sparks-nv' => 'Sparks, NV', 'spokane-wa' => 'Spokane, WA', 'spring-hill-fl' => 'Spring Hill, FL', 'spring-hill-tn' => 'Spring Hill, TN', 'spring-tx' => 'Spring, TX',
'spring-valley-nv' => 'Spring Valley, NV', 'springdale-ar' => 'Springdale, AR', 'springfield-il' => 'Springfield, IL', 'springfield-ma' => 'Springfield, MA', 'springfield-mo' => 'Springfield, MO',
'springfield-oh' => 'Springfield, OH', 'springfield-or' => 'Springfield, OR', 'st-augustine-fl' => 'St. Augustine, FL', 'st-charles-mo' => 'St. Charles, MO', 'st-clair-shores-mi' => 'St. Clair Shores, MI',
'st-cloud-fl' => 'St. Cloud, FL', 'st-cloud-mn' => 'St. Cloud, MN', 'st-george-ut' => 'St. George, UT', 'st-joseph-mo' => 'St. Joseph, MO', 'st-louis-mo' => 'St. Louis, MO',
'st-louis-park-mn' => 'St. Louis Park, MN', 'st-paul' => 'St. Paul, MN', 'st-pete-beach-fl' => 'St. Pete Beach, FL', 'st-peters-mo' => 'St. Peters, MO', 'st-petersburg-fl' => 'St. Petersburg, FL',
'state-college-pa' => 'State College, PA', 'staten-island-ny' => 'Staten Island, NY', 'sterling-heights-mi' => 'Sterling Heights, MI', 'stillwater-ok' => 'Stillwater, OK', 'stockton-ca' => 'Stockton, CA',
'stonecrest-ga' => 'Stonecrest, GA', 'suffolk-va' => 'Suffolk, VA', 'sugar-land-tx' => 'Sugar Land, TX', 'summerville-sc' => 'Summerville, SC', 'sumter-sc' => 'Sumter, SC',
'sunnyvale-ca' => 'Sunnyvale, CA', 'sunrise-fl' => 'Sunrise, FL', 'sunrise-manor-nv' => 'Sunrise Manor, NV', 'surprise-az' => 'Surprise, AZ', 'syracuse' => 'Syracuse, NY',
'tacoma-wa' => 'Tacoma, WA', 'tallahassee-fl' => 'Tallahassee, FL', 'tamarac-fl' => 'Tamarac, FL', 'tamiami-fl' => 'Tamiami, FL', 'tampa-fl' => 'Tampa, FL',
'taunton-ma' => 'Taunton, MA', 'taylor-mi' => 'Taylor, MI', 'taylorsville-ut' => 'Taylorsville, UT', 'temecula-ca' => 'Temecula, CA', 'tempe-az' => 'Tempe, AZ',
'temple-tx' => 'Temple, TX', 'terre-haute-in' => 'Terre Haute, IN', 'texarkana-tx' => 'Texarkana, TX', 'texas-city-tx' => 'Texas City, TX', 'the-hammocks-fl' => 'The Hammocks, FL',
'the-villages-fl' => 'The Villages, FL', 'the-woodlands-tx' => 'The Woodlands, TX', 'thornton-co' => 'Thornton, CO', 'thousand-oaks-ca' => 'Thousand Oaks, CA', 'tigard-or' => 'Tigard, OR',
'tinley-park-il' => 'Tinley Park, IL', 'titusville-fl' => 'Titusville, FL', 'toledo' => 'Toledo, OH', 'topeka-ks' => 'Topeka, KS', 'torrance-ca' => 'Torrance, CA',
'town-n-country-fl' => "Town 'n' Country, FL", 'towson-md' => 'Towson, MD', 'tracy-ca' => 'Tracy, CA', 'trenton-nj' => 'Trenton, NJ', 'troy-mi' => 'Troy, MI',
'troy-ny' => 'Troy, NY', 'tuckahoe-va' => 'Tuckahoe, VA', 'tucson-az' => 'Tucson, AZ', 'tulare-ca' => 'Tulare, CA', 'tulsa-ok' => 'Tulsa, OK',
'turlock-ca' => 'Turlock, CA', 'tustin-ca' => 'Tustin, CA', 'twin-falls-id' => 'Twin Falls, ID', 'tyler-tx' => 'Tyler, TX', 'union-city-ca' => 'Union City, CA',
'union-city-nj' => 'Union City, NJ', 'university-fl' => 'University, FL', 'upland-ca' => 'Upland, CA', 'utica' => 'Utica, NY', 'vacaville-ca' => 'Vacaville, CA',
'valdosta-ga' => 'Valdosta, GA', 'vallejo-ca' => 'Vallejo, CA', 'vancouver-wa' => 'Vancouver, WA', 'ventura-ca' => 'Ventura, CA', 'victorville-ca' => 'Victorville, CA',
'victoria-tx' => 'Victoria, TX', 'vineland-nj' => 'Vineland, NJ', 'virginia-beach-va' => 'Virginia Beach, VA', 'vista-ca' => 'Vista, CA', 'waco-tx' => 'Waco, TX',
'wake-forest-nc' => 'Wake Forest, NC', 'waldorf-md' => 'Waldorf, MD', 'walnut-creek-ca' => 'Walnut Creek, CA', 'waltham' => 'Waltham, MA', 'warner-robins-ga' => 'Warner Robins, GA',
'warren-mi' => 'Warren, MI', 'warrenton' => 'Warrenton, VA', 'warwick-ri' => 'Warwick, RI', 'washington-dc' => 'Washington, DC', 'waterbury-ct' => 'Waterbury, CT',
'waterloo-ia' => 'Waterloo, IA', 'watsonville-ca' => 'Watsonville, CA', 'waukegan-il' => 'Waukegan, IL', 'waukesha-wi' => 'Waukesha, WI', 'wausau-wi' => 'Wausau, WI',
'wauwatosa-wi' => 'Wauwatosa, WI', 'wellington-fl' => 'Wellington, FL', 'wenatchee-wa' => 'Wenatchee, WA', 'wesley-chapel-fl' => 'Wesley Chapel, FL', 'west-allis-wi' => 'West Allis, WI',
'west-jordan-ut' => 'West Jordan, UT', 'west-new-york-nj' => 'West New York, NJ', 'west-palm-beach-fl' => 'West Palm Beach, FL', 'west-valley-city-ut' => 'West Valley City, UT', 'westchester-fl' => 'Westchester, FL',
'westfield-in' => 'Westfield, IN', 'westland-mi' => 'Westland, MI', 'westminster-ca' => 'Westminster, CA', 'westminster-co' => 'Westminster, CO', 'weston-fl' => 'Weston, FL',
'wheaton-il' => 'Wheaton, IL', 'wheaton-md' => 'Wheaton, MD', 'white-plains-ny' => 'White Plains, NY', 'whittier-ca' => 'Whittier, CA', 'wichita-falls-tx' => 'Wichita Falls, TX',
'wichita-ks' => 'Wichita, KS', 'williamsburg-va' => 'Williamsburg, VA', 'wilmington-nc' => 'Wilmington, NC', 'wilmington-de' => 'Wilmington, DE', 'wilson-nc' => 'Wilson, NC',
'winchester-va' => 'Winchester, VA', 'winter-haven-fl' => 'Winter Haven, FL', 'winston-salem-nc' => 'Winston-Salem, NC', 'woodbury-mn' => 'Woodbury, MN', 'woodland-ca' => 'Woodland, CA',
'worcester-ma' => 'Worcester, MA', 'wylie-tx' => 'Wylie, TX', 'wyoming-mi' => 'Wyoming, MI', 'yakima-wa' => 'Yakima, WA', 'yonkers-ny' => 'Yonkers, NY',
'yorba-linda-ca' => 'Yorba Linda, CA', 'york' => 'York, PA', 'youngstown-oh' => 'Youngstown, OH', 'yuba-city-ca' => 'Yuba City, CA', 'yucaipa-ca' => 'Yucaipa, CA', 'yuma-az' => 'Yuma, AZ'
];
// Sort cities alphabetically
ksort($cities);
?>
<main>
<!-- Page Hero -->
<div class="page-hero">
<div class="container">
<?php nexagen_render_breadcrumb(); ?>
<div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Our Markets</div>
<h1>WordPress Services Across All Major US Markets</h1>
<p>We proudly offer our skills, knowledge, and expertise in all 50 states and 800+ cities, to bring our website design services to more customers.<br>Visit your local market page and learn more about our services.</p>
</div>
</div>

<!-- Stats Section (Matching Locations Template Design) -->
<section class="stats-section">
<div class="stats-container">
<div class="stats-grid">
<div class="stat-card">
<div class="stat-number">370+</div>
<div class="stat-label">5-Star Google Reviews</div>
</div>
<div class="stat-card">
<div class="stat-number">2,500+</div>
<div class="stat-label">Happy Clients Served</div>
</div>
<div class="stat-card">
<div class="stat-number">50+</div>
<div class="stat-label">In-House WP Experts</div>
</div>
<div class="stat-card">
<div class="stat-number">15+</div>
<div class="stat-label">Years in Business</div>
</div>
</div>
</div>
</section>

<!-- Nationwide visual -->
<div style="position:relative;overflow:hidden;max-height:280px;">
<img src="https://images.unsplash.com/photo-1434626881859-194d67b2b86f?w=1400&h=280&fit=crop&auto=format&q=70"
alt="Affordable Web Solution serving businesses nationwide across all US markets"
loading="lazy"
style="width:100%;height:280px;object-fit:cover;display:block;filter:brightness(0.4);">
<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
<div style="font-family:var(--font-heading);font-weight:900;font-size:2rem;margin-bottom:0.5rem;">Nationwide Market Coverage</div>
<p style="opacity:0.85;font-size:1.0625rem;max-width:540px;">From New York to California — our US-based team delivers world-class WordPress websites to local businesses in every major market.</p>
</div>
</div>

<!-- STATES SECTION (Matching Locations Template Design) -->
<section class="section">
<div class="container">
<div class="section-header text-center">
<div class="section-label" style="justify-content:center;">Where We Work</div>
<h2>Serving All 50 US States</h2>
<p style="max-width:700px;margin:0 auto;">Click your state to find local WordPress web design services and a list of cities we cover.</p>
</div>

<!-- States Grid (From Locations Template) -->
<div class="states-grid">
<?php foreach ($states as $slug => $state): ?>
<a href="<?php echo esc_url(home_url('/' . $slug . '/')); ?>"
class="card"
style="padding:1.25rem;text-align:center;text-decoration:none;display:block;">
<div style="font-family:var(--font-heading);font-weight:800;font-size:1.5rem;color:var(--color-primary);letter-spacing:-0.03em;display:block;margin-bottom:0.25rem;">
<?php echo esc_html($state['abbr']); ?>
</div>
<div style="font-size:0.8125rem;color:var(--color-body);"><?php echo esc_html($state['name']); ?></div>
<div style="font-size:0.75rem;color:var(--color-body);opacity:0.6;margin-top:0.25rem;"><?php echo count($state['cities']); ?> cities</div>
</a>
<?php endforeach; ?>
</div>

<div style="height: 1px; background: #e0e0e0; margin: 3rem auto; max-width: 200px;"></div>

<!-- CITIES SECTION (Keeping original list design as requested "states tak") -->
<div class="section-header text-center">
<h2>Local City Coverage</h2>
<p style="max-width:700px;margin:0 auto;">Affordable Web Solution also offers website design services to your local city. Our team is ready to support your business no matter where you are located.</p>
</div>

<ul class="location-listing">
<?php foreach ($cities as $slug => $city_name): ?>
<li>
<a href="<?php echo esc_url(home_url('/' . $slug . '/')); ?>">
<?php echo esc_html($city_name); ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</div>
</section>

<?php nexagen_render_why_us(); ?>
<?php nexagen_render_testimonials(3); ?>
<?php nexagen_render_cta('Ready to Grow in Your Local Market?', 'No matter where your business is located, Affordable Web Solution delivers exceptional, localized WordPress websites. Let\'s discuss your project.'); ?>
</main>


<?php get_footer(); ?>