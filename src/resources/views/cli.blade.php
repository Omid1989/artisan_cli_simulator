<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        body {
            background: #222;
            font-family: Menlo, Monaco, "Consolas";
            font-size: 16px;
            overflow: hidden;
        }

        pre {
            font-size: x-small
        }

        a {
            color:inherit;
        }

        a:hover {
            text-decoration: none;
            color: inherit;
        }

        p {
            color: rgb(136, 146, 176);
        }

        .title {
            color: rgba(255, 255, 255, 0.94);
        }

        .sidebar {
            background-color: rgb(41, 41, 41);
            display: flex;
            align-items: center;
            flex-direction: column;
            border-radius: 5px;
            color: rgb(0, 0, 0);
            opacity: 1;
        }
        .sidebar-link {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: rgba(139, 180, 216, 0.94);
        }

        .sidebar-link:hover {
            color: rgb(230, 241, 255);
        }
        .header-name {
            font-weight: 500;
            color: rgb(255, 255, 255);
        }
        .h5{
            color:white;
        }
        mark {
            background-color:Yellow;
            color: black;
        }

        .column-header {
            border-bottom: 2px rgb(68, 11, 11) solid;
            margin-bottom: 1rem;
        }

        .column-header > h1 {
            font-family: "Lato", sans-serif;
            font-weight: 100;
            color: white;
        }

        .icons,
        .sidebar-link {
            transition-duration: 250ms;
        }

        .icon:hover {
            color: white;
        }

        .terminal-bar {
            background-color: #eae8e9;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            display: flex;
            position: relative;
        }

        .dark-mode {
            background-image: linear-gradient(180deg, #464248 0%, #3b383d 100%);
            border-bottom: 1px solid rgba(66, 66, 66, 0.5);
        }

        .dark-mode-text {
            color: #bdb9bf !important;
        }

        .icon-btn {
            border-radius: 50%;
            margin-top: 7px;
            height: 15px;
            width: 15px;
            margin-bottom: 0.5rem;
        }

        .terminal-bar > div.icon-btn:first-child {
            margin-left: 0.6rem;
        }

        .terminal-bar > div.icon-btn:not(:first-child) {
            margin-left: 0.5rem;
        }

        .terminal-bar > div.icon-btn:last-child {
            margin-right: 0.6rem;
        }

        .close {
            background-color: #fa615c;
        }

        .max {
            background-color: #3fc950;
        }

        .min {
            background-color: #ffbd48;
        }

        .terminal-window {

            background-color: black;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            height: 500px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .primary-bg {
            background-color: rgb(23, 42, 69);
        }

        .shadow {
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.55);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.55);
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        }

        .terminal-bar-text {
            position: absolute;
            margin-top: 6px;
            color: #383838;
            width: 100%;
            text-align: center;
            font-weight: 500;
        }

        .has-equal-height {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .terminal-output {
            overflow-y: hidden;
            overflow: auto;
        }

        .column-child {
            /* flex: 1; */
            width: 80%;
            margin: auto;
        }

        .terminal-line {
            position: relative;
            font-family: "Anonymous Pro", monospace;
            font-size: 0.9rem;
            color: #b7c5d2;
        }

        .directory {
            color: #75e1e7;
            font-weight: 500;
        }

        .success {
            color: #8dd39e;
        }

        .code,
        .error,
        .fa-heart {
            color: #d7566a;
        }

        .fa-heart {
            padding-top: 0.5rem;
        }

        .dummy-keyboard {
            opacity: 0;
            filter: alpha(opacity=0);
        }

        ::-webkit-scrollbar {
            display: none;
        }

        @media screen and (max-width: 768px) {
            .resume {
                padding-bottom: 0.5rem;
            }
        }


    </style>
</head>
<body>

<div class="content">

    <section class="hero is-fullheight">

        <div class="hero-body">

            <div class="container">


                <br>
                <div class="column is-flex">

                    <div class="column-child terminal shadow">

                        <div class="terminal-bar dark-mode">


                            <div class="icon-btn close"></div>

                            <div class="icon-btn min"></div>

                            <div class="icon-btn max"></div>

                            <div class="terminal-bar-text is-hidden-mobile dark-mode-text">CLI Artisan Terminal/Libary</div>
                        </div>

                        <div class="terminal-window primary-bg" onclick="document.getElementById('dummyKeyboard').focus();">

                            <div class="terminal-output" id="terminalOutput">

                                <div class="terminal-line">
                                    <span class="help-msg">You are now in my brain.<br> ~Type <span class="code">list</span> for a list of artisan  supported commands.<br></span>
                                </div>

                            </div>

                            <div class="terminal-line">
                                <span class="success">➜ php artisan </span> <span class="directory">~</span> <span class="user-input" id="userInput"></span>
                                <input type="text" id="dummyKeyboard" class="dummy-keyboard">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



    </section>
</div>
<script>
    const BLACKLISTED_KEY_CODES = [38];
    let userInput, terminalOutput;

    const app = () => {
        userInput = document.getElementById("userInput");
        terminalOutput = document.getElementById("terminalOutput");
        document.getElementById("dummyKeyboard").focus();
        console.log("Application loaded");
    };

    const execute = function executeCommand(input) {
        let output;
        input = input.toLowerCase();
        if (input.length === 0 ) {
            return;
        }
        //////////////////
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/artisan-cli-runner',
            type:"POST",
            data:{
                command:input,
                _token: _token
            },
            success:function(response){

                if(response) {
                    output =   `<div class="terminal-line"><span class="success">➜</span> <span class="directory">~</span>
                                php artisan ${response.command}
                                  <pre>${response.output}</pre></div>`;

                    terminalOutput.innerHTML = `${
                        terminalOutput.innerHTML
                    }<div class="terminal-line">${output}</div>`;
                    terminalOutput.scrollTop = terminalOutput.scrollHeight;
                }
            },
        });
        };

    const key = function keyEvent(e) {
        const input = userInput.innerHTML;

        if (BLACKLISTED_KEY_CODES.includes(e.keyCode)) {
            return;
        }

        if (e.key === "Enter") {
            execute(input);
            userInput.innerHTML = "";
            return;
        }

        userInput.innerHTML = input + e.key;
    };

    const backspace = function backSpaceKeyEvent(e) {
        if (e.keyCode !== 8 && e.keyCode !== 46) {
            return;
        }
        userInput.innerHTML = userInput.innerHTML.slice(
            0,
            userInput.innerHTML.length - 1
        );
    };

    document.addEventListener("keydown", backspace);
    document.addEventListener("keypress", key);
    document.addEventListener("DOMContentLoaded", app);

</script>
</body>
</html>
