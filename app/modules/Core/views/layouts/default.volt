<!DOCTYPE html>
<html lang="en">
<head>
    <title>{% block title %}{% endblock %}</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>

<body>

<div class="content">

    {% block header -%}
    {%- endblock %}

    {{ partial('layouts/partials/header')  }}

    <div class="row-fluid row-after-header">
        <div>
            {{ content() }}
            {{ flashSession.output() }}
        </div>
    </div>

    <div class="row-fluid main-content">
        <div class="container">

            <div class="row">

                <div class="col-md-3">
                    <p class="lead">Sidebar</p>
                    <div class="list-group">
                        <a href="{{ url(['for':'cart-index']) }}" class="list-group-item">Cart</a>
                        <a href="{{ url(['for':'product-show', 'id':'1', 'slug':'slug'])}}" class="list-group-item">Product</a>
                    </div>
                </div>

                <div class="col-md-9">

                    <div class="row">

                        <div class="col-md-9">
                            {%- block content -%}
                            {%- endblock %}
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    {{ partial('layouts/partials/footer')  }}
</div>

</body>
</html>