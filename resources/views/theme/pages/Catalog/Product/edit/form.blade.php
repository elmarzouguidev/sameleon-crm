<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>

                @include('theme.layouts._parts.__messages')

                <form action="{{route('commercial:catalog.products.update',$product)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">Nom *</label>
                                <input id="name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="brand">Marque</label>
                                <select class="form-select select2 @error('brand') is-invalid @enderror" name="brand"
                                    id="brand" required>
                                    <option>Select</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{$product->brand_id == $brand->id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="reference">Réference *</label>
                                <input id="reference" name="reference" type="text"
                                    class="form-control @error('reference') is-invalid @enderror" value="{{$product->reference}}" required>
                                @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price">Prix *</label>
                                        <input id="price" name="price" type="number"
                                            class="form-control @error('price') is-invalid @enderror" value="{{$product->price}}">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price">Quantité *</label>
                                        <input id="price" name="quantity" type="number"
                                            class="form-control @error('quantity') is-invalid @enderror" value="{{$product->quantity}}">
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Catégorie</label>
                                <select class="form-control select2 @error('category') is-invalid @enderror"
                                    name="category" id="category">
                                    <option>Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{$product->category_id == $category->id ? 'selected' : ''}}  >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{--<div class="mb-3">
                                <label class="control-label">Couleurs</label>

                                <select
                                    class="select2 form-control select2-multiple @error('colors') is-invalid @enderror"
                                    multiple="multiple" name="colors" data-placeholder="Choose ...">

                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach

                                </select>
                                @error('colors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>--}}
                            <div class="mb-3">
                                <label for="productdesc">Description</label>
                                <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="productdesc"
                                    rows="5">{{$product->description}}</textarea>
                                    
                                
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label>Image *</label>

                                        <input class="form-control @error('photo') is-invalid @enderror" name="photo"
                                            type="file" accept="image/*" />
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <div class="col-lg-10">
                                            <img src="{{ $product->getFirstMediaUrl('products_images', 'normal') }}"
                                            class="img-fluid" width="80">
                                        </div>

                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                        <button type="button" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
