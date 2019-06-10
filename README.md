# EzyAgric Backend
[![CircleCI](https://circleci.com/gh/Akorion/ezyagric-backend-2019/tree/dev.svg?style=svg)](https://circleci.com/gh/Akorion/ezyagric-backend-2019/tree/dev)  <a href="https://codeclimate.com/repos/5ce2b0943e13e4019f00cbd5/test_coverage"><img src="https://api.codeclimate.com/v1/badges/cfa77d4d54b520a72130/test_coverage" /></a>

========================================
### Get all input suppliers
#### Request
`GET /api/v1/input-suppliers`
#### Response
```
{
    "success": true,
    "count": 1,
    "inputSuppliers": [
        {
            "DateAdded": "2018-08-31",
            "DateUpdated": "11/9/2018",
            "_id": "00366319c2d145ff83b46d588ed88e86",
            "category": "Herbicides",
            "crops": [
                "beans",
                "soya"
            ],
            "description": "Selective weed killer for beans and soya",
            "eloquent_type": "input",
            "name": "Beans Clean",
            "photo_url": "/images/7e185f0a-cfc5-45a3-bb4d-6ef6535a5042.png",
            "price": [
                38100,
                21000
            ],
            "quantity": 9992,
            "supplier": "Hangzhou Agrochemicals (U) Ltd",
            "type": "input",
            "unit": [
                "1Litre",
                "500ml"
            ]
        }
    ]
}
```

### Get all village agents
#### Request
`GET /api/v1/village-agents`
#### Response
```
{
    "success": true,
    "count": 1,
    "villageAgents": [
        {
            "_id": "248833b0262f4ddeaa8d69105677f886",
            "agriculture_experience_in_years": "NA",
            "assets_held": "NA",
            "certification_doc_url": "NA",
            "education_doc_url": "NA",
            "education_level": "NA",
            "eloquent_type": "va",
            "farmers_enterprises": "NA",
            "ma_id": "AK/MA/0421",
            "other_occupation": "NA",
            "partner_id": "NA",
            "position held_in_community": "NA",
            "service_provision_experience_in_years": "NA",
            "services_va_provides": "NA",
            "status": "active",
            "time": "2018-07-05T21:48:13:141586",
            "total_farmers_acreage": "NA",
            "total_number_of_farmers": "NA",
            "type": "va",
            "vaId": "AK/MA/0421/0001",
            "va_country": "Uganda",
            "va_district": "rukungiri",
            "va_dob": "NA",
            "va_gender": "female",
            "va_home_gps_Accuracy": "NA",
            "va_home_gps_Altitude": "NA",
            "va_home_gps_Latitude": "NA",
            "va_home_gps_Longitude": "NA",
            "va_id_number": "NA",
            "va_id_type": "NA",
            "va_name": "Nyesiga Benadeth",
            "va_parish": "Nyakariro",
            "va_phonenumber": 789394948,
            "va_photo": "https =>//drive.google.com/open?id=1MwZuPcWTOcJYa6536Buk9FEc5i7HrZ3U",
            "va_region": "Western",
            "va_subcounty": "Bwambara",
            "va_village": "Kashayo"
        }
    ]
}
```