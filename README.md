# teapot

A simple teapot implementation based on DriftPHP https://driftphp.io .

Usage:
- composer install
- vendor/bin/server run 0.0.0.0:8000 --dev --debug
- open browser at 0.0.0.0:8000 to say hello
- do a post request against 0.0.0.0:8000/brew with your choice:

```json
{
    "type": "coffee",
    "amountOfCups": 5
}
```

or
```json
{
    "type": "tea",
    "amountOfCups": 3
}
```