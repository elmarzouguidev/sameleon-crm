<div class="row">
    <div class="col-xl-8">
        <div class="row mt-4">
            <div class="col-sm-6">
                <a href="{{route('commercial:catalog.products.create')}}" class="btn btn-secondary">
                   Ajouter Produit 
                </a>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end mt-2 mt-sm-0">
                    <a href="ecommerce-checkout.html" class="btn btn-success">
                        <i class="mdi mdi-cart-arrow-right me-1"></i> Checkout </a>
                </div>
            </div>
        </div>
        <div class="card">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Product Desc</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th colspan="2">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)
                                
                                <tr>
                                    <td>
                                        <img src="{{$product->getFirstMediaUrl('products_images','normal')}}" alt="product-img"
                                            title="product-img" class="avatar-md" />
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">{{$product->name}}</a></h5>
                                        <p class="mb-0">Color : <span class="fw-medium">Maroon</span></p>
                                    </td>
                                    <td>
                                        {{$product->sell_price}}
                                    </td>
                                    <td>
                                        <div style="width: 120px;">
                                            <input type="text" value="02" name="demo_vertical">
                                        </div>
                                    </td>
                                    <td>
                                        $ 900
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="action-icon text-danger"> <i class="mdi mdi-trash-can font-size-18"></i></a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-6">
                        <a href="ecommerce-products.html" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping </a>
                    </div> <!-- end col -->
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <a href="ecommerce-checkout.html" class="btn btn-success">
                                <i class="mdi mdi-cart-arrow-right me-1"></i> Checkout </a>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Details</h5>
                
                <div class="card bg-primary text-white visa-card mb-0">
                    <div class="card-body">
                        <div>
                            <i class="bx bxl-visa visa-pattern"></i>
                        
                            <div class="float-end">
                                <i class="bx bxl-visa visa-logo display-3"></i>
                            </div>

                            <div>
                                <i class="bx bx-chip h1 text-warning"></i>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-4">
                                <p>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                </p>
                            </div>
                            <div class="col-4">
                                <p>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                    <i class="fas fa-star-of-life m-1"></i>
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h5 class="text-white float-end mb-0">12/22</h5>
                            <h5 class="text-white mb-0">Fredrick Taylor</h5>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Order Summary</h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td>Grand Total :</td>
                                <td>$ 1,857</td>
                            </tr>
                            <tr>
                                <td>Discount : </td>
                                <td>- $ 157</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge :</td>
                                <td>$ 25</td>
                            </tr>
                            <tr>
                                <td>Estimated Tax : </td>
                                <td>$ 19.22</td>
                            </tr>
                            <tr>
                                <th>Total :</th>
                                <th>$ 1744.22</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
        <!-- end card -->
    </div>
</div>