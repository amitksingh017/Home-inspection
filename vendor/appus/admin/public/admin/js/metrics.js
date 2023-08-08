$('body').on('change', '.metric-filter select', function () {
    const $_this = $(this);
    const value = $_this.val();
    const name = $_this.attr('name');
    const key = $_this.closest('.metric-item').attr('data-key');
    setMetricParam(name, value, key, false);
});

function getMetric(key) {
    const item = $('.metric-item[data-key="' + key + '"]');
    const formElement = item.find('form.metric-form');
    const url = formElement.attr('action');
    const form = formElement.serialize();
    const container = item.find('.content');
    container.html('<div class=loader></div>');
    $.post(url, form, function (response) {
        container.html(response);
    });
}

function drawLineChart(data, id, title, type) {
    var echartLine = echarts.init(document.getElementById(id));
    if ('undefined' === typeof type) {
        type = 'line';
    }
    let charts = [];
    let legend = [];
    $.each(data, function(key, val) {
        legend.push(key);
        charts.push(val);
    });
    echartLine.setOption({
        height: '65%',
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            top: '20px'
        },
        legend: {
            x: 'center',
            y: 270,
            data: legend,
            orient: 'vertical',
            type: 'scroll',
            height: 50
        },
        calculable: true,
        xAxis: [{
            type: 'category',
            boundaryGap: true,
            data: legend
        }],
        yAxis: [{
            type: 'value'
        }],
        series: {
            type: type,
            smooth: true,
            data: charts
        }
    });
}

function drawDonut(data, id, title, donut) {
    var echartDonut = echarts.init(document.getElementById(id));

    let innerRadius = '35px';

    if ('undefined' === typeof donut) {
        donut = true;
    }

    if (!donut) {
        innerRadius = '0';
    }

    let legend = [];
    let chartData = [];

    $.each(data, function (key, val) {
        legend.push(key);
        chartData.push({
            name: key,
            value: val
        });
    });

    echartDonut.setOption({
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        calculable: true,
        legend: {
            x: 'right',
            y: 'top',
            data: legend,
            orient: 'vertical',
            type: 'scroll',
            height: 125
        },
        series: [{
            name: title,
            type: 'pie',
            radius: [innerRadius, '62px'],
            center: ['25%', '50%'],
            itemStyle: {
                normal: {
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                },
                emphasis: {
                    label: {
                        show: false,
                        position: 'center',
                        textStyle: {
                            fontSize: '14',
                            fontWeight: 'normal'
                        }
                    }
                }
            },
            data: chartData
        }]
    });
}

function setMetricParam(name, value, key, isHidden) {
    if (isHidden) {
        const item = $('.metric-item[data-key="' + key + '"]');
        const formElement = item.find('form.metric-form');
        formElement.find('input[name="' + name + '"]').remove();
        formElement.append('<input type="hidden" name="' + name + '" value="' + value + '" />');
    }
    getMetric(key);
}
