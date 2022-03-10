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
        "Coords": "",
        "": 0.0
    }
]

const defaultPlaceholderTimetable = [
    ["10am-2pm", "1110011"],
    ["2pm-6pm", "1101100"],
    ["6pm-11pm", "0110011"],
    ["11pm-10am", "1001011"]
];

function generateMarkerData(){

}

function getReviews(){
    return defaultPlaceholderReviews;
}

function getMarkers(){
    return defaultPlaceholderMarkers;
}

function getTimetable(){
    let timetable = defaultPlaceholderTimetable;
    if(sessionStorage != null){
        timetable[0][1] = sessionStorage.getItem["10am2pm"];
        timetable[1][1] = sessionStorage.getItem["2pm6pm"];
        timetable[2][1] = sessionStorage.getItem["6pm11pm"];
        timetable[3][1] = sessionStorage.getItem["11pm10am"];
    }
    return timetable;
}