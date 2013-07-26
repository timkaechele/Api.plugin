 
# Kirby API
Like all modern APIs the Kirby API is RESTful. So you are able retrieve all wished Data by simply using standard HTTP Methods.  You don't have to deal with crappy XML-RPC or SOAP.

**API Authentication is coming soon**


# Documentation
Until now we provide 3 major API sections:

* Site
* Page
* File

## Site
The Site API provides general informations about your Kirby Site like 'How many sites do I have' or all parent pages.

### api/site/
#### Method: GET
```shell
$ curl http://myawesomepage.com/api/site
```
#### Response

```json
{
    "url": "http://myawesomepage.com",
    "pages": [
        {
            "num": "01",
            "uid": "about-us",
            "uri": "about-us",
            "title": "About"
        },
        {
            "num": "02",
            "uid": "projects",
            "uri": "projects",
            "title": "Projects"
        },
        {
            "num": "03",
            "uid": "contact",
            "uri": "contact",
            "title": "Contact"
        },
        {
            "num": null,
            "uid": "error",
            "uri": "error",
            "title": "Error"
        },
        {
            "num": null,
            "uid": "home",
            "uri": "home",
            "title": "Home"
        }
    ],
    "content": {
        "raw": {
            "title": "Kirby",
            "author": "Bastian Allgeier",
            "description": "Kirby is awesome",
            "keywords": "kirby, cms, kirbycms, php, filesystem",
            "copyright": "© 2009-(date: Year) (link: http://bastianallgeier.com text: Bastian Allgeier)"
        },
        "html": {
            "title": "<p>Kirby</p>\n",
            "author": "<p>Bastian Allgeier</p>\n",
            "description": "<p>Kirby is awesome</p>\n",
            "keywords": "<p>kirby, cms, kirbycms, php, filesystem</p>\n",
            "copyright": "<p>© 2009-2013 <a href=\"http://bastianallgeier.com\">Bastian Allgeier</a></p>\n"
        }
    },
    "files": []
}
```

### api/site/stats
#### Method: GET
```shell
$ curl http://myawesomepage.com/api/stats
```
#### Response

```json
{
    "pages": {
        "total": 8,
        "visible": 6,
        "invisible": 2
    },
    "files": {
        "total": 1,
        "images": 0,
        "videos": 0,
        "sounds": 0,
        "documents": 0,
        "others": 0
    }
}
```

### api/site/index
Gives back an array with all pages at the site
#### Method: GET
```shell
$ curl http://myawesomepage.com/api/index
```
#### Response
```json
[
    {
        "url": "http://myawesomepage.com/about-us",
        "uid": "about-us",
        "uri": "about-us",
        "tinyurl": "http://myawesomepage.com/x/1qsu399"
    },
    {
        "url": "http://myawesomepage.com/projects",
        "uid": "projects",
        "uri": "projects",
        "tinyurl": "http://myawesomepage.com/x/poq46c"
    },
    {
        "url": "http://myawesomepage.com/projects/project-a",
        "uid": "project-a",
        "uri": "projects/project-a",
        "tinyurl": "http://myawesomepage.com/x/e1kw3g"
    },
    {
        "url": "http://myawesomepage.com/projects/project-b",
        "uid": "project-b",
        "uri": "projects/project-b",
        "tinyurl": "http://myawesomepage.com/x/1bluoqu"
    },
    {
        "url": "http://myawesomepage.com/projects/project-c",
        "uid": "project-c",
        "uri": "projects/project-c",
        "tinyurl": "http://myawesomepage.com/x/1p79aog"
    },
    {
        "url": "http://myawesomepage.com/contact",
        "uid": "contact",
        "uri": "contact",
        "tinyurl": "http://myawesomepage.com/x/l7027s"
    },
    {
        "url": "http://myawesomepage.com/error",
        "uid": "error",
        "uri": "error",
        "tinyurl": "http://myawesomepage.com/x/q1lpbl"
    },
    {
        "url": "http://myawesomepage.com",
        "uid": "home",
        "uri": "home",
        "tinyurl": "http://myawesomepage.com/x/vl2sb4"
    }
]
```



## Page

### api/page/[:uri]
#### Method: GET
```shell
$ curl http://myawesomepage.com/api/page/projects
```
#### Response

```json
{
    "id": "cdc465e23a6e2f1b4e8274b783a6fda5",
    "num": "02",
    "uid": "projects",
    "uri": "projects",
    "url": "http://myawesomepage.com/projects",
    "tinyurl": "http://myawesomepage.com/x/poq46c",
    "children": [
        {
            "uri": "projects/project-a",
            "title": "Project A"
        },
        {
            "uri": "projects/project-b",
            "title": "Project B"
        },
        {
            "uri": "projects/project-c",
            "title": "Project C"
        }
    ],
    "template": "default",
    "content": {
        "raw": {
            "title": "Projects",
            "text": "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,"
        },
        "html": {
            "title": "<p>Projects</p>\n",
            "text": "<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,</p>\n"
        }
    },
    "files": [
        {
            "uri": "projects/Portfolio.zip",
            "url": "http://myawesomepage.com/content/02-projects/Portfolio.zip"
        }
    ]
}
```

### api/page/create/[:uri]
#### Method: POST
```shell
$ curl -X POST http://myawesomepage.com/api/page/create/mypage --data 'content[title]=MyTitle&cotent[text]=MyText&num=04&template=default'
```
#### Parameter
* **num:** the sorting number of the page
* **content:** an array with content
* **template:** the template name that should be used

#### Response
```json
{
    "status": "success",
    "code": 200,
    "message": "The page has been created",
    "data": {
        "id": "9808e4a0861f9101fb0b9c1bf47f2cf9",
        "num": "04",
        "uid": "mypage",
        "uri": "mypage",
        "url": "http://myawesomepage.com/mypage",
        "tinyurl": "http://myawesomepage.com/x/1if7gkl",
        "children": [],
        "template": "default",
        "content": {
            "raw": {
                "title": "MyTitle"
            },
            "html": {
                "title": "<p>MyTitle</p>\n"
            }
        },
        "files": []
    }
}

```
### api/page/update/[:uri]
#### Method: PUT/POST
```shell
$ curl -X PUT http://myawesomepage.com/api/page/update/mypage --data 'content[title]=anotherTitle&content[text]=anotherText'
```
#### Parameter
* **content:** an array with content

#### Response
```json
{
    "status": "success",
    "code": 200,
    "message": "page successfully updated",
    "data": {
        "id": "9808e4a0861f9101fb0b9c1bf47f2cf9",
        "num": "05",
        "uid": "mypage",
        "uri": "mypage",
        "url": "http://myawesomepage.com/mypage",
        "tinyurl": "http://myawesomepage.com/x/1if7gkl",
        "children": [],
        "template": "default",
        "content": {
            "raw": {
                "text": "anotherText"
            },
            "html": {
                "text": "<p>anotherText</p>\n"
            }
        },
        "files": []
    }
}
```

### api/page/delete/[:uri]
#### Method: DELETE
```shell
$ curl -X DELETE http://myawesomepage.com/api/page/delete/mypage
```

#### Response
```json
{
    "status": "success",
    "code": 200,
    "message": "successfully deleted",
    "data": []
}
```
## File

### api/file/[:uri]
#### Method: GET
```shell
$ curl http://myawesomepage.com/api/file/projects/Portfolio.zip
```
#### Response

```json
{
    "url": "http://myawesomepage.com/content/02-projects/Portfolio.zip",
    "name": "Portfolio",
    "filename": "Portfolio.zip",
    "mime": "application/zip",
    "extension": "zip",
    "size": 1214196,
    "nicesize": "1.16 mb",
    "type": "archive",
    "meta": {
        "raw": [],
        "html": []
    }
}
```


### api/file/create/[:uri]
#### Method: POST
```shell
$ curl -F name=file -F filedata=@localfile.jpg http://myawesomepage.com/api/file/create/mypage/File.png
```
#### Parameter
* **File**: the actual file
* **Meta**: an array with meta informations

#### Response
```json
{
    "status": "success",
    "code": 200,
    "message": "The file has been created",
    "data": []
}
```

### api/file/update/[:uri]
Updates or replaces a file and the belonging metainformations
#### Method: PUT/POST
```shell
$ curl -X PUT http://myawesomepage.com/api/file/update/mypage/File.png --data @fileupdate.png
```
#### Parameter
* **file:** The actual file.
* **meta:** an array with meta information

#### Response

```json
{
    "status": "success",
    "code": 200,
    "message": "file successfully updated",
    "data": []
}
```

### api/file/delete/[:uri]
Deletes the given File
#### Method: DELETE
```shell
$ curl -X DELETE http://myawesomepage.com/api/file/delete/mypage/myfile 
```
```json
{
    "status": "success",
    "code": 200,
    "message": "File has been deleted",
    "data": []
}
```
