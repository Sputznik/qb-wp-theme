<?php
    add_action('wp_footer', 'my_back_to_top_button');
    function my_back_to_top_button() {
        ?>
        <a href="#" id="back-to-top" title="Back to Top">
            <i class="bx bx-chevron-up"></i>
            <span class="sr-only">Back to Top</span>
        </a>
        <style>
            #back-to-top {
                position: fixed;
                bottom: 40px;
                right: 40px;
                width: 40px;
                height: 40px;
                line-height: 40px;
                background-color: black;
                color: #fff;
                text-align: center;
                font-size: 20px;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                text-decoration: none;
                display: none;
                z-index: 9999;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            #back-to-top:hover {
                background-color: #555;
                transform: scale(1.1);
            }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('back-to-top');
            window.addEventListener('scroll', function() {
                if (window.scrollY > window.innerHeight) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });
        </script>
        <?php
    }