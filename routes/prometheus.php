<?php

Route::any('/metrics', 'PrometheusController@doMetrics');