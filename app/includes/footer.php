<style>
    .footer {
        background: #303036;
        color: #d3d3d3;
        height: 400px;
        position: relative;
    }

    .footer h2 {
        font-family: "roboto", serif;
        color: #5c5b5b;
        margin: 0px;
    }

    .footer a {
        font-family: "roboto", serif;
        color: #5c5b5b;
        margin: 0px;
    }

    .footer .footer-content {
        height: 350px;
        display: flex;
    }

    .footer .footer-content .footer-section {
        flex: 1;
        padding: 25px;
    }

    .footer .footer-content h1,
    .footer .footer-content h2 {
        color: white;
    }

    .footer .footer-content .about h1 span {
        color: orange;
    }

    .footer .footer-content .about .contact span {
        display: block;
        font-size: 1.1em;
        margin-bottom: 8px;
        margin-top: 8px;
    }

    .footer .footer-content .about .socials a {
        border: 1px solid gray;
        width: 45px;
        height: 41px;
        margin-right: 5px;
        display: inline-block;
        font-size: 1.3em;
        border-radius: 5px;
        transition: all 0.3s;
        position: relative;
    }

    .footer .footer-content .about .socials a i {
        margin: 0;
        top: 50%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
    }

    .footer .footer-content .about .socials a:hover {
        border: 1px solid white;
        color: white;
        transition: all 0.3s;
    }

    .footer .footer-content .links ul { padding: 0; list-style: none; 
    }
    .footer .footer-content .links ul a {
        display: block;
        margin-bottom: 10px;
        font-size: 1.2em;
        transition: all 0.3s;
    }

    .footer .footer-content .links ul a:hover {
        color: orange;
        transform: translate(10px,0);
        transition: all 0.5s; 
    }

    .footer .footer-content .contact-form .contact-input {
        background: #272727;
        color: #bebdbd;
        margin-bottom: 10px;
        line-height: 1.5rem;
        padding: 0.9rem 1.4rem;
        border: none;
    }

    .footer .footer-content .contact-form .contact-input:focus {
        background: #1a1a1a;
    }

    .footer .footer-content .contact-form .contact-btn {
        float: right;
        font-size: 1.1em;
        font-family: "Lora", serif;
    }

    .footer .footer-bottom {
        background: #343a40;
        color: #686868;
        height: 100px;
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 0px;
        left: 0px;
        padding-top: 20px;
    }

    .round_icon {
        width: 34px;
        height: 34px;
        display: flex;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .roundd {
        width: 34px;
        height: 34px;
        border-radius: 34px;
        vertical-align: middle;
        margin-bottom: 10px;
    }
</style>
<div class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h1 class="logo-text"><span>CL </span>Channel</h1>
            <p style="font-size:15px">
                Enjoy Your Breakthroughs
            </p>
            <div class="contact">
                <span style="font-size:15px"><i class="fas fa-phone"></i> &nbsp; +852 54494239</span>
                <span style="font-size:15px"><i class="fas fa-envelope"></i> &nbsp; yu-kuan.ding@connect.polyu.hk</span>
            </div>
            <!--<div class="socials">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-weixin"></i></a>
            </div>
            -->
        </div><div class="footer-section links">
            <h2>LINKS</h2>
            <br>
            <ul>
                <a target="_blank" href="https://www.comp.polyu.edu.hk/">
                    <li>PolyU COMP</li>
                </a>
                <a target="_blank" href="about">
                    <li>Develop Team</li>
                </a>
                <a target="_blank" href="Pcentre">
                    <li>Projects</li>
                </a>
            </ul>
 <!--
        <div class="footer-section links">
            <h2>Learn</h2>
            <br>
            <ul>
                <a href="#">
                    <li>Events</li>
                </a>
                <a href="#">
                    <li>Team</li>
                </a>
                <a href="#">
                    <li>Mentores</li>
                </a>
                <a href="#">
                    <li>Gallery</li>
                </a>
                <a href="#">
                    <li>Terms and Conditions</li>
                </a>
            </ul>
        </div>

        <div class="footer-section links">
            <h2>Practice</h2>
            <br>
            <ul>
               
                <a href="#">
                    <li>Events</li>
                </a>
                <a href="#">
                    <li>Team</li>
                </a>
                <a href="#">
                    <li>Mentores</li>
                </a>
                <a href="#">
                    <li>Gallery</li>
                </a>
                <a href="#">
                    <li>Terms and Conditions</li>
                </a>
            </ul>
        </div>


        <div class="footer-section links">
            <h2>Company</h2>
            <br>
            <ul>
                
                <a href="#">
                    <li>Events</li>
                </a>
                <a href="#">
                    <li>Team</li>
                </a>
                <a href="#">
                    <li>Mentores</li>
                </a>
                <a href="#">
                    <li>Gallery</li>
                </a>
                <a href="#">
                    <li>Terms and Conditions</li>
                </a>
            </ul>
        </div>

        <div class="footer-section links">
            <h2>Society</h2>
            <br>
            <ul>
                <a href="#">
                    <li>Events</li>
                </a>
                <a href="#">
                    <li>Team</li>
                </a>
                <a href="#">
                    <li>Mentores</li>
                </a>
                <a href="#">
                    <li>Gallery</li>
                </a>
                <a href="#">
                    <li>Terms and Conditions</li>
                </a>
            </ul>
        </div>
-->
        <!--  <div class="footer-section contact-form">
        <h2>Contact us</h2>
        <br>
        <form action="index.html" method="post">
          <input type="email" name="email" class="text-input contact-input" placeholder="Your email address...">
          <textarea rows="4" name="message" class="text-input contact-input" placeholder="Your message..."></textarea>
          <button type="submit" class="btn btn-big contact-btn">
            <i class="fas fa-envelope"></i>
            Send
          </button>
        </form>
      </div> -->

    </div>

    <div class="footer-bottom">
        <div>
            <img src="https://www.w3cplus.com/sites/default/files/blogs/2020/2004/css-circle-image-2.jpg" class="roundd" alt="">
            <img src="https://www.w3cplus.com/sites/default/files/blogs/2020/2004/css-circle-image-2.jpg" class="roundd" alt="">
            <img src="https://www.w3cplus.com/sites/default/files/blogs/2020/2004/css-circle-image-2.jpg" class="roundd" alt="">
            <img src="https://www.w3cplus.com/sites/default/files/blogs/2020/2004/css-circle-image-2.jpg" class="roundd" alt="">
        </div>
        &copy; CL Channel | Developed by CLC Workgroup
    </div>
</div>