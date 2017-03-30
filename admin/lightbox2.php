<!DOCTYPE html> 
<html>
    <head>
        <title>Simple Lightbox</title>
        <style>
            #imagelightbox
            {
                position: fixed;
                z-index: 9999;

                -ms-touch-action: none;
                touch-action: none;
            }
        </style>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/imagelightbox.min.js"></script>
        <script>
            $(function ()
            {
                $('a').imageLightbox();
            });
        </script>


    </head>
    <body>
        <a href="../upload/grao6.jpg" data-imagelightbox="a" >
            <img src="../upload/grao6.jpg" alt="Klaipeda in the night" width="50" height="50">
        </a>


    </body>
</html>