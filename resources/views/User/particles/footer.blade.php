<footer style="background:#111; color:#ccc; padding:40px 0; margin-top:50px;">

    <div class="container text-center">

        <!-- Footer Menu -->
        <div class="mb-3">
            @foreach(getFooterMenus() as $menu)
                <a href="{{ url($menu->link) }}" class="text-light me-3" style="text-decoration:none;">
                    {{ $menu->name }}
                </a>
            @endforeach
        </div>

        <!-- Copyright -->
        <p class="mb-0">
            © {{ date('Y') }} MyShop. All Rights Reserved.
        </p>

    </div>

</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



