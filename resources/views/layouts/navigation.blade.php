<header class="header-area">
    <div class="container-fluid bg-nav">
        <div class="container">
            <div class="nav-content">
                <!-- Logo and Search -->
                <div class="left-group">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="GamersWorld" height="40">
                        <span class="text-white">GamersWorld</span>
                    </a>

                    <form action="" method="GET" class="search-form">
                        <div class="search-group">
                            <input type="text"
                                name="query"
                                placeholder="Search for products..."
                                class="search-input">
                            <button type="submit" class="search-btn">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Navigation Links -->
                <div class="right-group">
                    <a href="{{ url('/') }}" class="nav-link">Home</a>
                    <div class="dropdown"><a href="{{ url('/products') }}" class="nav-link">Products</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('ps2') }}" class="dropdown-item">PS2 Games</a></li>
                            <li><a href="{{ url('xbox-original') }}" class="dropdown-item">Xbox Original Games</a></li>
                        </ul>
                    </div>
                    <a href="{{ url('/about') }}" class="nav-link">About Us</a>
                    <a href="{{ url('/contact') }}" class="nav-link">Contact Us</a>
                    <a href="{{ url('/customer/account') }}" class="nav-link">Account</a>
                    <div class="nav-end-group">
                        <a href="{{ route('logout') }}" class="nav-link">Logout</a>
                        <a href="{{ url('/cart') }}" class="nav-link">Shopping Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .nav-link {
        color: #fff !important;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
    }

    .nav-link:hover {
        color: rgba(255, 255, 255, 0.8) !important;

    }

    .bg-nav {
        background-color: #61777f;
        padding: 10px 0;
        width: 100%;
    }

    .nav-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 40px;
    }

    .left-group {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        text-decoration: none;
    }

    .search-form {
        margin: 0;
    }

    .search-group {
        display: flex;
        height: 32px;
    }

    .search-input {
        width: 200px;
        padding: 0 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-right: none;
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-btn {
        padding: 0 15px;
        background: #556970;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        cursor: pointer;
    }

    /* Media query adjustments */
    @media (max-width: 1200px) {
        .search-input {
            width: 150px;
        }
    }


    .right-group {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-end-group {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-link {
        color: #2a2a2a;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
    }

    .nav-link:hover {
        color: #000;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #61777f;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 8px 0;
        margin: 0;
        list-style: none;
        border-radius: 4px;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-item {
        color: #fff;
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background-color: #556970;
        color: #fff;
    }

    @media (max-width: 1200px) {
        .dropdown-menu {
            position: static;
            width: 100%;
            margin-top: 5px;
            box-shadow: none;
        }

        .dropdown {
            width: 100%;
            text-align: center;
        }

        .nav-content {
            flex-wrap: wrap;
            height: auto;
            gap: 15px;
        }

        .left-group {
            width: 100%;
            justify-content: space-between;
        }

        .right-group {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .nav-end-group {
            display: inline-flex;
            gap: 15px;
        }

        .nav-link {
            font-size: 13px;
        }

        .search-input {
            width: 150px;
        }
    }

    @media (max-width: 768px) {
        .bg-nav {
            padding: 10px;
        }

        .right-group {
            gap: 10px;
        }

        .nav-end-group {
            gap: 10px;
        }
    }
</style>