<!doctype html>
<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.6/axios.min.js"></script>
    </head>
    <body>
        <img id="frame" width="1000" height="1000" onkeydown="keyPress(event)" tabindex="0">
        <script>
            const image = document.getElementById('frame');
            function updateImage(binary) {
                image.src = '';
                image.src = `data:image/png;base64, ${binary}`;
            }
            function keyPress(event) {
                axios.post('actions.php', {
                    x: event.clientX,
                    y: event.clientY,
                    code: event.code,
                });
            }
            setInterval(function () {
                axios.get('game.php?binary').then((response) => updateImage(response.data));
            }, 50)
        </script>
    </body>
</html>
