# usedb-laravel

### 1) Introduction

Laravel-usedb is a Generic-CRUD composer package for Laravel apps which eliminates the need to write Apis for each and every model in a Laravel app.

### 2) Motivation

The idea came out to simplify the job of developers who had to create a similar type of CRUD apis for different projects. Using this package, you can perform CRUD operations to any model in your project.

### 3) Features

- **URL**: All the request will counter at the same url i.e. <APP_URL>/usedb.
- **Generic Controller**: CRUD operations for any Model is handled by the same controller.

### 4)**Installation**

```bash
#COMPOSER
composer require geekyants/laravel-usedb
```

After installation, run the command below to move package's config files to your project config.

```jsx
php artisan vendor:publish --tag=config
```

### 5) Usage

All API request is received at <APP_URL>/usedb and method type will always of type POST.

The fields which are mandatory, while sending requests are as follows:

- **collection**: It contains the name of the model on which operation has to be performed.
- **operation**: Name of the operation.
- **payload**: It contains different values on the basis of the type of operation.

  Mandatory fields in the payload

  | Operation | Fields      |
  | --------- | ----------- |
  | create    | data        |
  | findOne   | where       |
  | findMany  | skip, take  |
  | update    | data, where |
  | delete    | where       |

1. create data
2. findOne where
3. findMany skip, take
4. update data, where
5. delete where

[Mandatory fields in payload](https://www.notion.so/526fe17b4a5a41f49975d43c2c877ef4)

### Adding Middleware

The middleware property of the usedb.php config file contains entries for the middleware to be included with our route. If you would like to assign middleware to routes, make an entry in the middleware. By default, usedb, and model-usedb middlewares are added in the config.

### Setting Model class path

The modelPath property of usedb.php contains the path of the directory from which the Model class has to be loaded. By default, its value is assigned to "App\Models\\" which is Laravel's default directory for models.

### Authorization

Authorization can be done in two ways: Gates and Policies. After creating them, you need to mention them in the usedb config file.

1. **Gates**: To map the gate to a particular operation of a model, you have to define it in the gates property of type array in the permissions field.
   Syntax:

```jsx
'gates' => [
		'modelName' => [
        'update' => [],
        'delete' => [],
        'create' => [],
        'findOne' => [],
        'findMany' => []
    ]
]
```

modelName represents the name of the model in which you want to apply gates. `update`, `delete`, `create`, `findOne`, and `findMany` maps to the array of gates to be applied to their respective operations.

2.  **Policy**: To policy to a certain operation of a particular model, you have to define it in the `policies` property of type array in the `permissions` field.
    The syntax for the same:

```jsx
'policies' => [
	'update' => '',
        'delete' => '',
        'create' => '',
        'findOne' => '',
        'findMany' => ''
    ]
]
```

modelName represents the name of the model in which you want to apply policies. `update`, `delete`, `create`, `findOne`, and `findMany` maps to the policy to be applied to their respective operations.

### Association

When you want objects to be returned with their associated models, then you have to mention the property to access child elements from a parent in the `include` property of `payload` field of the JSON provided.

For example, we have an OneToMany relation between Blogs and comments. Now we want to retrieve the blog with its associated comments, then its JSON will be:

```jsx
{
    "collection":"Blog",
    "operation":"findOne",
    "payload": {
        "where":{
            "id": 139
        },
       "include":{
            "comments":{}
        }
    }
}
```

### 6) Example

Let's say, we have a Post model having a single property: caption. CRUD example for Post model are as follows:

1. create

```bash
{
	"collection":"Post",
	"operation":"create",
	"payload": {
			"data":
			{
				"caption": "Caption of the post"
			}
	}
}

```

2.  findOne

```jsx
{
	"collection":"Post",
	"operation":"findOne",
	"payload": {
			"where":
			{
				"id": 1
			}
	}
}
```

3.  update

```jsx
{
    "collection":"Post",
    "operation":"update",
    "payload": {
        "data": {
            "caption": "changed caption"
        },
        "where": {
            "id" : 10
        }
    }
}
```

4.  delete

```jsx
{
    "collection":"Post",
    "operation":"delete",
    "payload": {
        "where": {
            "id" : 3
        }
    }
}
```

5.  findMany

```jsx
{
    "collection":"Post",
    "operation":"findMany",
    "payload": {
        "where": {
            "caption": "hello"
        },
        "skip": 1,
        "take": 5
    }
}
```
