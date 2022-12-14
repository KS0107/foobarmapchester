const defaultPlaceholderReviews = [
    {
        "id": "1",
        "location": "Mojo",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Pretty Good"
    },
    {
        "id": "2",
        "location": "Mojo",
        "date": "2022-02-12",
        "rating": "5",
        "review": "Amazing"
    },
    {
        "id": "3",
        "location": "Footage",
        "date": "2022-01-21",
        "rating": "2",
        "review": "Bit Crowded"
    },
    {
        "id": "4",
        "location": "Footage",
        "date": "2022-01-03",
        "rating": "5",
        "review": "Cheap drinks, good music"
    },
    {
        "id": "5",
        "location": "Footage",
        "date": "2022-02-07",
        "rating": "4",
        "review": "Fun pub quiz and good selection of drinks"
    },
    {
        "id": "6",
        "location": "Cargo",
        "date": "2021-12-01",
        "rating": "2",
        "review": "Massive queue, expensive drinks"
    },
    {
        "id": "7",
        "location": "Cargo",
        "date": "2021-11-13",
        "rating": "4",
        "review": "Fast entry, Very cheap drinks for a club"
    },
    {
        "id": "8",
        "location": "Cargo",
        "date": "2021-11-05",
        "rating": "5",
        "review": "Lots of good music choices, good environment and cheap shots"
    },
    {
        "id": "9",
        "location": "Mojo",
        "date": "2022-01-15",
        "rating": "3",
        "review": "Bit pricey but stayed open late"
    },
    {
        "id": "10",
        "location": "Factory",
        "date": "2022-02-05",
        "rating": "4",
        "review": "Alright overall"
    },
    {
        "id": "11",
        "location": "Factory",
        "date": "2021-10-02",
        "rating": "5",
        "review": "Really fun night, vodka was good"
    },
    {
        "id": "12",
        "location": "Gay",
        "date": "2022-01-08",
        "rating": "5",
        "review": "Open late, good songs and fun things to do"
    },
    {
        "id": "15",
        "location": "Turing Tap",
        "date": "2022-02-23",
        "rating": "5",
        "review": "Was there for a soc thing, was a good night"
    },
    {
        "id": "16",
        "location": "Turing Tap",
        "date": "2022-02-21",
        "rating": "4",
        "review": "Nice atmosphere, slightly questionnable music, drinks were not bad"
    },
    {
        "id": "17",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "4",
        "review": "Nice drinks, bit of a long walk though"
    },
    {
        "id": "18",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "2",
        "review": "No martinis"
    },
    {
        "id": "19",
        "location": "The Paramount",
        "date": "2022-02-16",
        "rating": "4",
        "review": "Good beer selection and easy to get to"
    }
];

const defaultPlaceholderMarkers = {
    'type': 'FeatureCollection',
    'features': [
        {
            'type': 'Feature',
            'properties': {
                'message': 'Factory',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.23733, 53.47404]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Turing Tap',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.22935, 53.46252]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Footage',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.23687, 53.47016]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Mojo',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.249815066033617, 53.481263991254615]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Gay',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.2379910112825154, 53.47647216906738]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'Cargo',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.2412459798138444, 53.48478796773415]
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'message': 'The Paramount',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [-2.242571365193075, 53.47653556884342]
            }
        }
    ]
};

const defaultPlaceholderLocations = [
    {
        "ID": 0,
        "Name": "Turing Tap",
        "Address": "",
        "Coords": [-2.22935, 53.46252],
        "AvgReview": 0.0
    }
]

const defaultPlaceholderTimetable = [
    ["10am-2pm", "1111111"],
    ["2pm-6pm", "0011100"],
    ["6pm-11pm", "0011100"],
    ["11pm-10am", "0011100"]
];

var locations = [];
var markers = {'type': 'FeatureCollection',
'features': []
};

function generateLocations(){
    for (let i = 1; i <= 22; i++) {
        locationObj = document.getElementById(i);
        locationData = locationObj.textContent.split(",");
        locationJSON = {
            "ID": 0,
            "Name": "Turing Tap",
            "Address": "",
            "Coords": [-2.22935, 53.46252],
            "AvgReview": 0.0
        }
        locationJSON.ID = i;
        locationJSON.Name = locationData[0];
        CoordList = [parseFloat(locationData[1]), parseFloat(locationData[2])]
        locationJSON.Coords = CoordList;
        locations.push(locationJSON);
    }
}

function generateMarkerData(){
    generateLocations();
    locations.forEach(element =>{
        var blankLocation = {
            'type': 'Feature',
            'properties': {
                'message': '',
                'iconSize': [40, 40]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [0, 0]
            },
        }
        blankLocation.properties.message = element.Name;
        blankLocation.geometry.coordinates = element.Coords;
        markers.features.push(blankLocation);
    });
}

function getLocations(){
    generateLocations();
    return locations;
}

function getReviews(){
    return defaultPlaceholderReviews;
}

function getMarkers(){
    generateMarkerData();
    return markers;
}

// function getTimetable(){
//     let timetable = defaultPlaceholderTimetable;
//     for (let i = 0; i < 4; i++) {
//         let cookieValue = document.cookie.split('; ').find(row => row.startsWith(timetable[i][0].replace("-", "")+'='));
//         if(cookieValue != undefined){
//             cookieValueSplit = cookieValue.split('=')[1];
//             timetable[i][1] = cookieValueSplit;
//         }
//     }
//     return timetable;
// }