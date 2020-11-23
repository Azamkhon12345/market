@extends('layouts.user')
@section('content')

    <!-- header end -->
    <div class="breadcrumb-area pt-205 pb-210" style="background-image: url(assets/img/bg/breadcrumb.jpg)">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h2>contact us</h2>
                <ul>
                    <li><a href="#">home</a></li>
                    <li> contact us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- shopping-cart-area start -->
    <div class="contact-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-map-wrapper">
                        <div class="contact-map mb-40">
                            <div id="hastech2"></div>
                        </div>
                        <div class="contact-message">
                            <div class="contact-title">
                                <h4>Contact Information</h4>
                            </div>
                            <form id="contact-form" class="contact-form" action="assets/mail.php" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="contact-input-style mb-30">
                                            <label>Name*</label>
                                            <input name="name" required="" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-input-style mb-30">
                                            <label>Email*</label>
                                            <input name="email" required="" type="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-input-style mb-30">
                                            <label>Telephone</label>
                                            <input name="telephone" required="" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-input-style mb-30">
                                            <label>subject</label>
                                            <input name="subject" required="" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="contact-textarea-style mb-30">
                                            <label>Comment*</label>
                                            <textarea class="form-control2" name="message" required=""></textarea>
                                        </div>
                                        <button class="submit contact-btn btn-hover" type="submit">
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-wrapper">
                        <div class="contact-title">
                            <h4>Location & Details</h4>
                        </div>
                        <div class="contact-info">
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="ti-location-pin"></i>
                                </div>
                                <div class="contact-info-text">
                                    <p><span>Address:</span>  1234 - Bandit Tringi lAliquam <br> Vitae. New York</p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="pe-7s-mail"></i>
                                </div>
                                <div class="contact-info-text">
                                    <p><span>Email: </span> Support@plazathemes.com</p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="pe-7s-call"></i>
                                </div>
                                <div class="contact-info-text">
                                    <p><span>Phone: </span>  (800) 0123 456 789</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shopping-cart-area end -->
    @endsection
@section('modals')
    <!-- modal -->
    <div class="modal fade" id="exampleCompare" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-dialog modal-compare-width" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="#">
                        <div class="table-content compare-style table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <a href="#">Remove <span>x</span></a>
                                        <img src="assets/img/cart/4.jpg" alt="">
                                        <p>Blush Sequin Top </p>
                                        <span>$75.99</span>
                                        <a class="compare-btn" href="#">Add to cart</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="compare-title"><h4>Description </h4></td>
                                    <td class="compare-dec compare-common">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has beenin the stand ard dummy text ever since the 1500s, when an unknown printer took a galley</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Sku </h4></td>
                                    <td class="product-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Availability  </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>In stock</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Weight   </h4></td>
                                    <td class="compare-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Dimensions   </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>N/A</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>brand   </h4></td>
                                    <td class="compare-brand compare-common">
                                        <p>HasTech</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>color   </h4></td>
                                    <td class="compare-color compare-common">
                                        <p>Grey, Light Yellow, Green, Blue, Purple, Black </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>size    </h4></td>
                                    <td class="compare-size compare-common">
                                        <p>XS, S, M, L, XL, XXL </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"></td>
                                    <td class="compare-price compare-common">
                                        <p>$75.99 </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
