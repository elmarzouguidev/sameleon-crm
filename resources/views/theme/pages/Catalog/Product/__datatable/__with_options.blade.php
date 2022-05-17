<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <a href="{{route('commercial:catalog.products.create')}}" class="btn btn-info"
                            data-bs-target=".addCategory">
                            Ajouter un produit
                        </a>
                    </div>
                </div>

                @include('theme.layouts._parts.__messages')
                
                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width: 20px;" class="align-middle">
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th>Image</th>
                            <th>Produit N°</th>
                            <th>Nom</th>
                            <th>Réf</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                    
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox"
                                            id="orderidcheck-{{ $product->id }}">
                                        <label class="form-check-label" for="orderidcheck-{{ $product->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <img class="img-fluid rounded" alt="" src="{{$product->getFirstMediaUrl('products_images','thumb')}}" width="50">
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ $product->url }}" class="text-body fw-bold">
                                        {{ $product->code }}
                                    </a>
                                </td>

                                <td>
                                    {{ $product->name }}
                                </td>
                                <td>
                                    {{ $product->reference }}
                                </td>
                                <td>
                                    {{ $product->quantity }}
                                </td>
                                <td>
                                    {{ $product->price }}
                                </td>
    
                                <td>
                                    <div class="d-flex gap-3">

                                        <a href="{{ route('commercial:catalog.products.edit',$product->uuid) }}" class="text-success">
                                            <i class="mdi mdi-pencil font-size-18"></i>
                                        </a>
                                        <a href="#" class="text-danger" onclick="
                                                var result = confirm('Are you sure you want to delete this invoice ?');

                                                if(result){
                                                    event.preventDefault();
                                                    document.getElementById('delete-product-{{ $product->uuid }}').submit();
                                                }">
                                            <i class="mdi mdi-delete font-size-18"></i>
                                        </a>
                                    </div>
                                </td>
                                <form id="delete-product-{{ $product->uuid }}" method="post"
                                    action="{{ route('commercial:catalog.products.delete') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="productId" value="{{ $product->uuid }}">
                                </form>
                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>