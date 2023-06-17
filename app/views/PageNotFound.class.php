<?php
class PageNotFound
{
    public function __invoke()
    {
        echo `
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>

        <body>
            <h1>Page not found</h1>
            <p>This page is the default page for not setting routes</p>
        </body>

        </html>
        `;
    }
}