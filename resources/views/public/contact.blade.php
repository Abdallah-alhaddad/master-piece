<x-app-layout>

    <section class="page-title bg-1">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="block text-center">
                <h3 class="text-white">Contact Us</h3>
                <h1 class="text-capitalize m-5 text-lg">Get in Touch</h1>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- contact form start -->

      <section class="section contact-info py-3">
          <div class="container">
               <div class="row">
                  <div class="col-lg-4 col-sm-6 col-md-6">
                      <div class="contact-block mb-4 mb-lg-0 p-2">
                          <i class="icofont-live-support"></i>
                          <h5>Call Us</h5>
                          079-2345-6789
                      </div>
                  </div>
                  <div class="col-lg-4 col-sm-6 col-md-6">
                      <div class="contact-block mb-4 mb-lg-0 p-2">
                          <i class="icofont-support-faq"></i>
                          <h5>Email Us</h5>
                           healpoint@gmail.com
                      </div>
                  </div>
                  <div class="col-lg-4 col-sm-6 col-md-6">
                      <div class="contact-block mb-4 mb-lg-0 p-2">
                          <i class="icofont-location-pin"></i>
                          <h5>Location</h5>
                           Amman
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <section class="contact-form-wrap section">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-lg-6">
                      <div class="section-title text-center">
                          <h2 class="text-md m-5">Contact us</h2>
                          <div class="divider mx-auto my-4"></div>
                          <p class="mb-5">Have any questions or need assistance? Feel free to reach out to us. We're here to help!</p>

                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                      <form id="contact-form" class="contact__form " method="post" action="mail.php">
                       <!-- form message -->
                          <div class="row">
                              <div class="col-12">
                                  <div class="alert alert-success contact__msg" style="display: none" role="alert">
                                      Your message was sent successfully.
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="form-group">
                                      <input name="name" id="name" type="text" class="form-control" placeholder="Your Full Name" >
                                  </div>
                              </div>

                              <div class="col-lg-6">
                                  <div class="form-group">
                                      <input name="email" id="email" type="email" class="form-control" placeholder="Your Email Address">
                                  </div>
                              </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                      <input name="subject" id="subject" type="text" class="form-control" placeholder="Your Query Topic">
                                  </div>
                              </div>
                               <div class="col-lg-6">
                                  <div class="form-group">
                                      <input name="phone" id="phone" type="text" class="form-control" placeholder="Your Phone Number">
                                  </div>
                              </div>
                          </div>

                          <div class="form-group-2 mb-4">
                              <textarea name="message" id="message" class="form-control" rows="8" placeholder="Your Message"></textarea>
                          </div>

                          <div class="text-center">
                              <input class="btn btn-main btn-round-full" name="submit" type="submit" value="Send Messege"></input>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </section>


</x-app-layout>
