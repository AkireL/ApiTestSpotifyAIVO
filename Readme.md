|||
---|---|
|Author| Erika Leonor Basurto Munguia|
|Version| 1.0.0|
|Date| 11/06/2020|
---
# Test Create End Point for search Albums by Artist's name


> Output End Point:

```json
[
    {
        "name": "Album Name",
        "released": "10-10-2010",
        "tracks": 10,
        "cover": {
            "height": 640,
            "width": 640,
            "url": "https://i.scdn.co/image/6c951f3f334e05ffa"
        }
    }
]
```
url: http://localhost/api/v1/albums?q=`<band-name>`

# Tecnologies
- Microframework 'Slim 3'
- Client Http 'Guzzle'
- API Spotify

