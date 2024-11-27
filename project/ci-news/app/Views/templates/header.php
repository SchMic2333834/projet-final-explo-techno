<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quantico:ital,wght@0,400;0,700;1,400;1,700&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <title><?= esc($title) ?></title>
    <style {csp-style-nonce}>
        em{
            text-align: center;
            color:white;
            width:100vw;
        }
        .quantico-regular {
            font-family: "Quantico", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .quantico-bold {
            font-family: "Quantico", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .quantico-regular-italic {
            font-family: "Quantico", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .quantico-bold-italic {
            font-family: "Quantico", sans-serif;
            font-weight: 700;
            font-style: italic;
        }
        * {
            box-sizing: border-box;
        }
        html, body{
            height:100%;
            width:100%;
            margin: 0;
        }
        .pAbout {
            width: 50%;
        }
        body {
            background: linear-gradient(135deg, #1f1f1f, #3b3b3b);
            font-family: "quantico", "regular";
        }

        ::-webkit-scrollbar {
            width: 24px;
            height: 16px;
        }

        ::-webkit-scrollbar-thumb {
            background: #4a4a4a;
            border-radius: 4px;
            border: 4px solid #1e1e1e;
        }

        ::-webkit-scrollbar-track {
            background: #1e1e1e;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5a5a5a;
        }

        ::-webkit-scrollbar-corner {
            background: #1e1e1e;
}
    </style>

