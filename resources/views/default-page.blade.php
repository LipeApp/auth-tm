<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://file.tmart.uz/4E60/favicon.ico?view">
    <title>{{ config('app.name') }}</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        body {
            background-image: url(https://file.tmart.uz/4E5r/fon.jpg?view);
            background-size: cover;
            font-family: "Roboto", sans-serif;
            height: 100vh;
        }

        .wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 38px 25px;
            height: 100%;
        }

        .site-logo {
            position: absolute;
            top: 38px;
            left: 25px;
        }

        .blocks {
            background: rgba(247, 247, 247, 0.01);
            backdrop-filter: blur(2px);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
        }

        .blocks .block-item {
            background: #ffffff;
            box-shadow: 0px 2px 10px 1px rgba(0, 0, 0, 0.07);
            border-radius: 24px;
            width: 48%;
            padding: 4px;
            color: #000;
            display: flex;
            align-items: center;
            margin: 0 40px 0 0;
            width: 100%;
        }

        .blocks .block-item:last-child {
            margin: 0;
        }

        .blocks .block-item .item-left {
            width: 100px;
            height: 100px;
            background: #edeeef;
            border-radius: 21px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 24px 0 0;
        }

        .blocks .block-item .title {
            font-weight: 600;
            font-size: 22px;
            line-height: 28px;
            margin-bottom: 10px;
        }

        .blocks .block-item .item-info {
            max-width: 332px;
            width: 100%;
            margin: 0 32px 0 0;
        }

    </style>
    <style type="text/css">.contentscript[data-v-9189e84e] {
            all: unset;
            text-align: left;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            height: 225px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 28px 10px 10px 10px;
            opacity: 0.95;
            background-color: #04367B;
            color: #C7C7C7;
            font-size: 16px;
            font-family: sans-serif;
            z-index: 2147483647;
            outline: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .contentscript *[data-v-9189e84e] {
            outline: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .contentscript .xpath-close-button-harness[data-v-9189e84e] {
            position: fixed;
            right: 0px;
            top: 0px;
            padding: 2px;
            font-size: 18px;
            width: 18px;
            text-align: center;
            line-height: 18px;
            background-color: #4671B2;
            outline: 1px solid #89B8FF;
            cursor: pointer;
        }

        .contentscript .xpath-output-harness[data-v-9189e84e] {
            background-color: #4671B2;
            outline: 1px solid #89B8FF;
            height: 175px;
            padding: 6px;
            font-family: monospace;
            font-size: 14px;
            overflow-y: auto;
        }

        .contentscript .xpath-output-harness .xpath-element-header[data-v-9189e84e] {
            font-size: 16px;
            font-weight: bold;
        }

        .contentscript .xpath-output-harness .xpath-element-content[data-v-9189e84e], .contentscript .xpath-output-harness .xpath-element-xpaths[data-v-9189e84e] {
            padding-left: 20px;
            padding-bottom: 8px;
        }

        .contentscript .xpath-output-harness .xpath-element-content span[data-v-9189e84e], .contentscript .xpath-output-harness .xpath-element-xpaths span[data-v-9189e84e] {
            font-style: italic;
        }

        .contentscript .xpath-button-harness[data-v-9189e84e] {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            padding-top: 10px;
        }

        .contentscript .xpath-button-harness .flex-spacer[data-v-9189e84e] {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        .contentscript .xpath-button-harness .show-outlines[data-v-9189e84e] {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .contentscript .xpath-button-harness .show-outlines input[data-v-9189e84e] {
            margin-left: 4px;
        }

        .contentscript .xpath-button-harness input[data-v-9189e84e] {
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        .contentscript .xpath-button-harness button[data-v-9189e84e] {
            all: unset;
            text-rendering: auto;
            color: #393939;
            letter-spacing: normal;
            word-spacing: normal;
            text-transform: none;
            text-indent: 0px;
            text-shadow: none;
            display: inline-block;
            text-align: center;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            background-color: #fff;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0em;
            padding: 1px 7px 2px;
            border-width: 1px;
            border-style: solid;
            border-color: #d8d8d8 #d1d1d1 #bababa;
            -o-border-image: initial;
            border-image: initial;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 8px;
        }

        .contentscript .xpath-button-harness button[data-v-9189e84e]:active {
            background-color: #F3B600;
        }

        .contentscript #xpath-copy-textarea-tiny-hidden[data-v-9189e84e] {
            max-height: 1px;
            max-width: 1px;
            min-height: 1px;
            min-width: 1px;
            height: 1px;
            width: 1px;
            padding: 1px;
            border: none;
            resize: none;
            outline-color: transparent;
            outline-style: none;
            background-color: #04367B;
        }
    </style>
</head>

<body cz-shortcut-listen="true">
<div class="wrapper">
    <div class="site-logo">
        <img src="https://file.tmart.uz/4E5v/texnomart-logo.svg?view" alt="">
    </div>
    <div class="blocks">
        <a href="{{ config('auth-tm.documentation_url', '#') }}" class="block-item">
            <div class="item-left">
                <img src="https://file.tmart.uz/4E5u/doc-icon.svg?view" alt="">
            </div>
            <div class="item-info">
                <div class="title">Документация</div>
                <div class="subtitle">Перейти к документации</div>
            </div>
            <div class="item-right">
                <img src="https://file.tmart.uz/4E5s/link-icon.svg?view" alt="">
            </div>
        </a>
        <a href="{{ config('auth-tm.home_page_url', '#') }}" class="block-item">
            <div class="item-left">
                <img src="https://file.tmart.uz/4E5q/admin-icon.svg?view" alt="">
            </div>
            <div class="item-info">
                <div class="title">Администрация</div>
                <div class="subtitle">Перейти к панели управления</div>
            </div>
            <div class="item-right">
                <img src="https://file.tmart.uz/4E5s/link-icon.svg?view" alt="">
            </div>
        </a>
    </div>
</div>




<div style="display: none" class="ubey-RecordingScreen-count-down ubey-RecordingScreen-count-down-container">
    <style>
        .ubey-RecordingScreen-count-down-container {
            position: fixed;
            height: 100vh;
            width: 100vw;
            top: 0;
            left: 0;
            z-index: 9999999999999;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .ubey-RecordingScreen-count-down-content {
            position: absolute;
            display: flex;
            top: 50%;
            left: 50%;
            justify-content: center;
            align-items: center;
            color: white;
            height: 15em;
            width: 15em;
            transform: translate(-50%, -100%);
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
        }

        #ubey-RecordingScreen-count-count {
            font-size: 14em;
            transform: translateY(-2%);
        }
    </style>
    <div class="ubey-RecordingScreen-count-down-content">
        <span id="ubey-RecordingScreen-count-count"></span>
    </div>
</div></body></html>
