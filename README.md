# EzyAgric Backend

[![CircleCI](https://circleci.com/gh/Akorion/ezyagric-backend-2019/tree/dev.svg?style=svg)](https://circleci.com/gh/Akorion/ezyagric-backend-2019/tree/dev) <a href="https://codeclimate.com/repos/5ce2b0943e13e4019f00cbd5/test_coverage"><img src="https://api.codeclimate.com/v1/badges/cfa77d4d54b520a72130/test_coverage" /></a>

========================================

### User Login

#### Request

`POST /api/v1/auth/login`

#### Request Body

```
{
    "email": "valid email",
    "password": "valid password"
}
```

#### Response

Admin

```
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs",
    "user": {
        "admin_address": "Rukungiri",
        "manager_phonenumber": "789394948",
        "admin_name": "Kubiri Youth Agents For Development",
        "_id": "ABAHAJOH788007645ADMIN",
        "status": "Open",
        "admin_id": "AK/MA/0421",
        "manager_name": "Nyesiga Benadeth",
        "time": "2018-07-05T20:12:21:662094",
        "type": "admin",
        "admin_email": "kubiri@akorion.com",
        "admin_value_chain": "crop",
        "manager_location": "Rukungiri",
        "manager_email": "nbenadeth@gmail.com",
        "email": "nbenadeth@gmail.com",
        "eloquent_type": "admin"
    }
}
```

Master Agent

```
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs",
    "user": {
        "ma_address": "Rukungiri",
        "manager_phonenumber": "789394948",
        "ma_name": "Kubiri Youth Agents For Development",
        "_id": "AK/MA/0421",
        "status": "Open",
        "ma_id": "AK/MA/0421",
        "manager_name": "Nyesiga Benadeth",
        "time": "2018-07-05T20:12:21:662094",
        "type": "ma",
        "ma_email": "kubiri@akorion.com",
        "ma_value_chain": "crop",
        "manager_location": "Rukungiri",
        "manager_email": "nbenadeth@gmail.com",
         "email": "nbenadeth@gmail.com",
        "eloquent_type": "admin"
    }
}
```

offtaker

```
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs",
    "user": {
        "partner_id": "AK/OT/0001",
        "ot_phonenumber": "256788345623",
        "type": "offtaker",
        "status": "active",
        "time": "2019-03-19 12:31:13.114047",
        "ot_name": "Luparelia",
        "_id": "AK/OT/0001",
        "ot_email": "ray@gmail.com",
        "ot_district": "Masaka",
        "ot_address": "lums",
         "email": "masteragent1234@gmail.com",
        "eloquent_type": "admin"
    }
}
```

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

### Create an Admin account

#### Request

`POST /api/v1/admin`

#### Request Body

```
{
         "email": "admin123@gmail.com",
        "password": "admin123",
        "confirmPassword":"admin123",
        "adminRole": "Super Admin"
}
```

#### Response

```
{
    "success": true,
    "admin": {
        "type": "admin",
        "email": "admincomeere@gnail.com",
        "adminRole": "Super Admin",
        "_id": "ClW9iT9",
        "updated_at": "2019-06-17 11:01:40",
        "created_at": "2019-06-17 11:01:40"
    }
}
```

### Create an Offtaker account

#### Request

`POST /api/v1/offtaker`

#### Request Body

```
{
        "email": "offtakehgjr@gmail.com",
        "password": "offtaker123456",
        "ot_username":"offtaker123456",
        "ot_name": "offtaker",
        "ot_account_type": "Custom Account",
        "ot_contact_person": "samuel",
        "ot_phonenumber":"32456789765",
        "ot_district": "somewhere",
         "ot_address": "somewhere",
        "ot_valuechain":"Diary"
}
```

#### Response

```
{
    "success": true,
    "offtaker": {
        "type": "offtaker",
        "email": "offtakehgjr@gmail.com",
        "ot_username": "offtaker123456",
        "ot_name": "offtaker",
        "ot_account_type": "Custom Account",
        "ot_contact_person": "samuel",
        "ot_phonenumber": "32456789765",
        "ot_district": "somewhere",
        "ot_address": "somewhere",
        "ot_valuechain": "Diary",
        "_id": "koPgF9Z",
        "updated_at": "2019-06-17 17:04:43",
        "created_at": "2019-06-17 17:04:43"
    }
}
```

==========================================================

### Create a MasterAgent account

#### Request

`POST /api/v1/create-masteragent`

#### Request Body

```
{
		"ma_manager_name": "AK/OT/0001",
        "ma_phonenumber": "256788345623",
        "password": "masteragent123456",
        "ma_name": "Luparelia",
        "email": "masteragent123456@gmail.com",
        "ma_district": "Masaka",
        "ma_username": "masteragent",
        "ma_address": "lums",
        "ma_valuechain":"Dairy",
        "ma_account_type":"Custom Account"
}
```

#### Response

```
{
    "success": true,
    "masterAgent": {
        "type": "ma",
        "status": "inactive",
        "ma_manager_name": "AK/OT/0001",
        "ma_phonenumber": "256788345623",
        "ma_name": "Luparelia",
        "email": "masteragent123456@gmail.com",
        "ma_district": "Masaka",
        "ma_address": "lums",
        "ma_account_type": "Custom Account",
        "_id": "xs8VF4Y",
        "updated_at": "2019-06-17 19:29:36",
        "created_at": "2019-06-17 19:29:36"
    }
}
```

### Get all development partners

#### Request

`GET /api/v1/devt-partners`

#### Response

```
{
    "success": true,
    "count": 1,
    "devtPartners": [
        {
            "_id": "AK/DP/0001",
            "account_type": "generic",
            "category": "development-partner",
            "dp_address": "NA",
            "dp_email": "devtest1@akorion.com",
            "dp_location": "NA",
            "dp_name": "Akorion Dev",
            "dp_password": "o2A8oo40^L",
            "dp_phonenumber": "256703276434",
            "eloquent_type": "partner",
            "partner_id": "AK/DP/0001",
            "status": "Open",
            "time": "2019-04-23 20:05:56.502024",
            "type": "partner",
            "value_chain": "crop"
        }
    ]
}
```


### Create a Development Partner account

#### Request

`POST /api/v1/dev-partner`

#### Request Body

```
{
    "email": "devpartner1234@gmail.com",
    "password": "devpartner1234",
    "dp_username": "devpartner",
    "dp_name": "devpartner",
    "account_type": "Custom",
    "dp_contact_person": "Samuel",
    "dp_phonenumber": "34567898765",
    "dp_district": "somewheere",
    "dp_address": "somewhere",
    "value_chain": "Crop"
}
```

#### Response

```
{
    "success": true,
    "devPartner": {
        "type": "partner",
        "category": "development-partner",
        "status": "closed",
        "email": "devpartner12345@gmail.com",
        "dp_username": "devpartner",
        "dp_name": "devpartner",
        "account_type": "Custom",
        "dp_phonenumber": "34567898765",
        "dp_district": "somewheere",
        "dp_address": "somewhere",
        "value_chain": "Crop",
        "_id": "7Svw6w0",
        "updated_at": "2019-06-18 15:53:04",
        "created_at": "2019-06-18 15:53:04"
    }
  "success": true,
  "topDistricts": {
    "Lagos": 2,
    "Rukungiri": 1
  }
}
```
=======
### Get top districts

#### Request

`GET /api/v1/top-districts`

#### Response

```
{
  "success": true,
  "topDistricts": {
    "Lagos": 2,
    "Rukungiri": 1
  }
}
```
=======
### Get total acreage for farmers

#### Request

`GET /api/v1/total-acreage`

#### Response

```
{
  "success": true,
  "totalAcreage": 6
}
```

