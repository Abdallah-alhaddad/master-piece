<!-- Footer Start -->
<footer class="footer section gray-bg">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 mr-auto col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <div class="logo mb-4">
                        <img src="/images/logo.png" alt="Heal Point" class="img-fluid" width="200">
                    </div>
                    <p>Heal Point connects patients with top healthcare professionals. Book appointments easily and manage your health journey with us.</p>

                    <ul class="list-inline footer-socials mt-4">
                        <li class="list-inline-item"><a href="#"><i class="icofont-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="icofont-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="icofont-linkedin"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="icofont-instagram"></i></a></li>
                    </ul>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-3">Quick Links</h4>
                    <div class="divider mb-4" style="background-color: #e12454;"></div>

                    <ul class="list-unstyled footer-menu lh-35">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('doctors') }}">Find Doctors</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
            </div>

            <!-- For Doctors -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-3">For Doctors</h4>
                    <div class="divider mb-4" style="background-color: #e12454;"></div>

                    <p>Join our network of healthcare professionals and grow your practice.</p>

                    <ul class="list-unstyled footer-menu lh-35">
                        <li><a href="{{ route('register.doctor') }}">Register Your Practice</a></li>
                        <li><a href="{{ route('doctor.login') }}">Doctor Login</a></li>
                        <li><a href="#">Benefits for Doctors</a></li>
                        <li><a href="#">Resources</a></li>
                    </ul>

                    <a href="{{ route('doctor.login') }}" class="btn btn-main btn-round-full mt-3">Join Our Network</a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="widget widget-contact mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-3">Contact Us</h4>
                    <div class="divider mb-4" style="background-color: #e12454;"></div>

                    <div class="footer-contact-block mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-email mr-3 text-primary"></i>
                            <span class="h6 mb-0">Email Us</span>
                        </div>
                        <h4 class="mt-2"><a href="mailto:info@healpoint.com">info@healpoint.com</a></h4>
                    </div>

                    <div class="footer-contact-block mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-phone mr-3 text-primary"></i>
                            <span class="h6 mb-0">Call Us</span>
                        </div>
                        <h4 class="mt-2"><a href="tel:+962790000000">+962 79 000 0000</a></h4>
                    </div>

                    <div class="footer-contact-block">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-location-pin mr-3 text-primary"></i>
                            <span class="h6 mb-0">Visit Us</span>
                        </div>
                        <h4 class="mt-2">Amman, Jordan</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-btm py-4 mt-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="copyright">
                        &copy; <script>document.write(new Date().getFullYear())</script> Heal Point. All Rights Reserved.
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-links text-lg-right mt-5 mt-lg-0">
                        <a href="#" class="mr-3">Privacy Policy</a>
                        <a href="#" class="mr-3">Terms of Service</a>
                        <a href="#">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="backtop js-scroll-trigger">
        <i class="icofont-long-arrow-up"></i>
    </a>
</footer>
<!-- Footer End -->
