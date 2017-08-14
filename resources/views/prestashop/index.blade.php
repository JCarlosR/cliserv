<section class="featured-products clearfix">
    <h1 class="h1 products-section-title text-uppercase">
        @if (isset($customerName))
            Productos destacados para {{ $customerName }}
        @else
            Productos destacados para tu país ({{ $countryCode }})
        @endif
    </h1>
    <div class="products">

        @foreach ($products as $product)
        <article class="product-miniature js-product-miniature" data-id-product="{{ $product->id_product }}" data-id-product-attribute="0" itemscope="" itemtype="http://schema.org/Product">
            <div class="thumbnail-container">

                <a href="http://clickstream.store/es/{{ $product->categoryName->link_rewrite }}/{{ $product->id_product }}-{{ $product->link_rewrite }}.html" class="thumbnail product-thumbnail">
                    <img src="http://clickstream.store/{{ $product->picture->id_image }}-home_default/{{ $product->link_rewrite }}.jpg" alt=""
                         data-full-size-image-url="http://clickstream.store/{{ $product->picture->id_image }}-large_default/{{ $product->link_rewrite }}.jpg">
                </a>


                <div class="product-description">
                    <h1 class="h3 product-title" itemprop="name">
                        <a href="http://clickstream.store/es/{{ $product->categoryName->link_rewrite }}/{{ $product->id_product }}-{{ $product->link_rewrite }}.html">
                            {{ $product->name }}
                        </a>
                    </h1>

                    <div class="product-price-and-shipping">
                        <span itemprop="price" class="price">{{ $product->price * 1.18 }}&nbsp;PEN</span>
                    </div>
                </div>


                <ul class="product-flags">
                </ul>
                <div class="highlighted-informations no-variants hidden-sm-down">
                    <a class="quick-view" href="#" data-link-action="quickview">
                        <i class="material-icons search"></i> Vista rápida
                    </a>
                </div>
            </div>
        </article>
        @endforeach

    </div>
    <a class="all-product-link pull-xs-left pull-md-right h4" href="http://clickstream.store/es/2-inicio">
        Todos los productos <i class="material-icons"></i>
    </a>
</section>