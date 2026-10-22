<div class="col-sm-12 flex-col-custom-1 col-md-4 mb-3">
    <div class="row">
        <div class="col-12">
            <div class="card-body">
                <h2 class="text-center">Budget</h2>
                <div style="width: 100%; height: 370px;" id="chartdiv_budget"></div>
            </div>
        </div>
    </div>
    @can('home_dashboard_chart_customer')
        <div class="row mt-5">
            <div class="col-12">
                <div class="card-body">
                    <h2 class="text-center">Sparkassen</h2>
                    <div style="width: 100%; height: 300px;" id="chartdiv_customer"></div>
                </div>
            </div>
        </div>
    @endcan
</div>