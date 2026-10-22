@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#customers_table tr, #customers_table thead tr, #measures_table thead tr').each(function(index) {
                var height = $(this).height();
                $('#contacts_table tr:eq(' + index + '), #contacts_table thead tr:eq(' + index + ')').height(height+4);
                $('#measures_table tr:eq(' + index + '), #measures_table thead tr:eq(' + index + ')').height(height+4);
            });

        });
        $('#show_all_contacts').add('#show_less_contacts').click(function(e){

            var filter = $('#filter').serializeArray()
            filter.push({name: 'numberOfItems', value: $(this).val()});

            e.preventDefault();

            getData(filter, 'customerContacts');
        });

        $('#show_all_measures').add('#show_less_measures').click(function(e){

            var filter = $('#filter').serializeArray()
            filter.push({name: 'numberOfItems', value: $(this).val()});

            e.preventDefault();

            getData(filter, 'customerMeasures');
        });

        function getData(filter, model) {

            let url = '';
            let selector = '';

            if (model === 'customerContacts') {
                url = "{{ url('backend/dashboard/contacts') }}";
                selector = "#contacts_table";
            }

            if (model === 'customerMeasures') {
                url = "{{ url('backend/dashboard/measures') }}";
                selector = "#measures_table";
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'GET',
                data: filter,

                success: function(dataResult)   {

                    $(selector).empty();

                    var resultData = dataResult.data;
                    var bodyData = '';

                    $.each(resultData,function(index,row){

                        var url = '{{ route("backend.customers.{customer}.show", ":id") }}';
                        showUrl = url.replace(':id', row.customer.id);

                        bodyData+="<tr>"

                        if (model === 'customerContacts') {

                            bodyData+="<td><a href='"+showUrl+"'>" +row.customer.name+ "</a></td>";
                            bodyData+="<td>" + row.user.name + "</td>";
                            bodyData+="<td>" +row.title+ "</td>";
                        }

                        if (model === 'customerMeasures') {

                            bodyData+="<td><a href='"+showUrl+"'>" +row.customer.name+ "</a></td>";
                            bodyData+="<td>" +row.measure.name+ "</td>";
                            bodyData+="<td>" + row.BadgeInformation + "</td>"
                        }

                        bodyData+="</tr>";
                    })

                    $(selector).append(bodyData);

                }});
        }

        var chart = am4core.create("chartdiv_budget", am4charts.PieChart);
        if (chart.logo) {
            chart.logo.disabled = true;
        }

        var positiveBudget = {{ $chartData['positive_budget_diagram'] }};
        var negativeBudget = {{ $chartData['negative_budget_diagram'] }}

        if (positiveBudget === 0 && negativeBudget === 0) {
            chart.data = [
                {
                    "institut": "Verfügbares Budget",
                    "amount": 50,
                    "color": am4core.color("#ffa500")
                },
                {
                    "institut": "Verbrauchtes Budget",
                    "amount": 50,
                    "color": am4core.color("#ED1C24")
                }
            ];
        } else {

            chart.data = [
                {
                    "institut": "Verfügbares Budget",
                    "amount": positiveBudget,
                    "color": am4core.color("#ffa500")
                },
                {
                    "institut": "Verbrauchtes Budget",
                    "amount": negativeBudget,
                    "color": am4core.color("#ED1C24")
                }
            ];

            //console.log(chart.data);
        }
        // Erstelle eine Instanz der NumberFormatter-Klasse
        var numberFormatter = new am4core.NumberFormatter();
        numberFormatter.numberFormat.numberGroupingSeparator = ",";

        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.category = "institut";
        pieSeries.dataFields.value = "amount";
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.ticks.template.disabled = true;
        pieSeries.alignLabels = false;
        pieSeries.labels.template.radius = am4core.percent(-40);
        pieSeries.legendSettings.labelText = "{category}";
        pieSeries.slices.template.states.create("hover").properties.scale = 1;
        chart.legend = new am4charts.Legend();
        chart.legend.valueLabels.template.disabled = true;

        if (positiveBudget === '0' && negativeBudget === '0') {
            pieSeries.labels.template.text = "0 €";
            pieSeries.tooltip.disabled = true;
        } else {

            pieSeries.labels.template.adapter.add("text", function(text, target) {
                //console.log(target.dataItem.dataContext.institut);
                if (target.dataItem && target.dataItem.dataContext && target.dataItem.dataContext.amount) {
                    if (target.dataItem.dataContext.institut == 'Verfügbares Budget') {
                        return positiveBudget.toLocaleString() + " €";
                    } else {
                        return negativeBudget.toLocaleString() + " €";
                    }
                }

            });
        }

        var chart = am4core.create("chartdiv_customer", am4charts.PieChart);
        if (chart.logo) {
            chart.logo.disabled = true;
        }

        // Add data

        if ('{{ $chartData['inactive_measures'] }}' === '0' && '{{ $chartData['active_measures'] }}' === '0') {
            // Add empty data for "Sparkassen ohne Maßnahme"
            chart.data = [{
                "institut": "Sparkassen ohne Maßnahme " + {{ \Carbon\Carbon::now()->year }},
                "amount": 50,
                "color": am4core.color("#ffa500")
            }, {
                "institut": "Sparkasse mit Maßnahme " + {{ \Carbon\Carbon::now()->year }},
                "amount": 50,
                "color": am4core.color("#ED1C24")
            }];
        } else {
            chart.data = [{
                "institut": "Sparkassen ohne Maßnahme " + {{ \Carbon\Carbon::now()->year }},
                "amount": '{{ $chartData['inactive_measures'] }}',
                "color": am4core.color("#ffa500")
            }, {
                "institut": "Sparkassen welche sich zu einer Maßnahme angemelet haben",
                "amount": '{{ $chartData['customer_measures'] }}',
                "color": am4core.color("#ED1C24")
            }];
        }


        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.category = "institut";
        pieSeries.dataFields.value = "amount";
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.ticks.template.disabled = true;
        pieSeries.alignLabels = false;

        pieSeries.labels.template.radius = am4core.percent(-40);
        pieSeries.legendSettings.labelText = "{category}";

        if ('{{ $chartData['inactive_measures'] }}' === '0' && '{{ $chartData['active_measures'] }}' === '0')
        {
            pieSeries.labels.template.text = "0";
            pieSeries.tooltip.disabled = true;
        }
        else
        {
            pieSeries.labels.template.text =  "{amount}";
        }


        chart.legend = new am4charts.Legend();
        chart.legend.valueLabels.template.disabled = true;

    </script>

@endpush
