import Chart from "chart.js/auto";

fetch("/dashboard/chart-data")
    .then(res => res.json())
    .then(data => {

        // ==========================
        // GDP
        // ==========================
        new Chart(document.getElementById("gdpChart"),{

            type:"bar",

            data:{

                labels:data.labels,

                datasets:[{

                    label:"GDP",

                    data:data.gdp,

                    backgroundColor:"#3B82F6"

                }]

            }

        });


        // ==========================
        // Inflation
        // ==========================

        new Chart(document.getElementById("inflationChart"),{

            type:"line",

            data:{

                labels:data.labels,

                datasets:[{

                    label:"Inflation",

                    data:data.inflation,

                    borderColor:"#F59E0B",

                    backgroundColor:"#FCD34D",

                    fill:false,

                    tension:0.4

                }]

            }

        });


        // ==========================
        // Currency
        // ==========================

        new Chart(document.getElementById("currencyChart"),{

            type:"line",

            data:{

                labels:data.labels,

                datasets:[{

                    label:"Exchange Rate",

                    data:data.currency,

                    borderColor:"#10B981",

                    backgroundColor:"#6EE7B7",

                    fill:false,

                    tension:0.4

                }]

            }

        });


        // ==========================
        // Risk
        // ==========================

        new Chart(document.getElementById("riskChart"),{

            type:"bar",

            data:{

                labels:data.labels,

                datasets:[{

                    label:"Risk Score",

                    data:data.risk,

                    backgroundColor:"#EF4444"

                }]

            }

        });

    });