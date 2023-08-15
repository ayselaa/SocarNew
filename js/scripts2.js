$(document).ready(function() {
    $('.one.col-md-3 a').click(function (event) {
        event.preventDefault();

        var modal = $('#largeModal');
        var carouselInner = modal.find('.carousel-inner');
        var currentIndex = $(this).parent().index();

        carouselInner.empty();

        var imageSrc = $(this).find('img').attr('src');
        carouselInner.append('<div class="carousel-item active"><img class="img-size" src="' + imageSrc + '" alt="Slide"></div>');

        modal.modal('show');

        modal.find('.carousel-control-next').click(function () {
            currentIndex = (currentIndex + 1) % $('.one.col-md-3').length;
            imageSrc = $('.one.col-md-3').eq(currentIndex).find('img').attr('src');

            carouselInner.empty();
            carouselInner.append('<div class="carousel-item active"><img class="img-size" src="' + imageSrc + '" alt="Slide"></div>');

        });
        modal.find('.carousel-control-prev').click(function () {
            currentIndex = (currentIndex - 1 + $('.one.col-md-3').length) % $('.one.col-md-3').length;
            imageSrc = $('.one.col-md-3').eq(currentIndex).find('img').attr('src');

            carouselInner.empty();
            carouselInner.append('<div class="carousel-item active"><img class="img-size" src="' + imageSrc + '" alt="Slide"></div>');
        });
    });
});


function reset_basic() {
    //reset formuláře
    document.getElementById('cng_basic').reset();
    //reset výsledků
    document.getElementById('benzin_rok').innerHTML = '0';
    document.getElementById('benzin_km').innerHTML = '0,00';
    document.getElementById('cng_rok').innerHTML = '0';
    document.getElementById('cng_km').innerHTML = '0,00';
    document.getElementById('uspora_rok').innerHTML = '0';
    document.getElementById('uspora_km').innerHTML = '0,00';
    //nové přepočítání
    calc_basic();
}

function reset_ext() {
    //reset formuláře
    document.getElementById('cng_ext').reset();
    //reset výsledků
    document.getElementById('benzin_rok').innerHTML = '0';
    document.getElementById('benzin_km').innerHTML = '0,00';
    document.getElementById('cng_rok').innerHTML = '0';
    document.getElementById('cng_km').innerHTML = '0,00';
    document.getElementById('uspora_rok').innerHTML = '0';
    document.getElementById('uspora_km').innerHTML = '0,00';
    document.getElementById('investice').innerHTML = '0';
    document.getElementById('amortizace').innerHTML = '0,0';
    //nové přepočítání
    calc_ext();
}
function verejna_stanice() {
    (document.getElementById('cena_verejna')).disabled = false;
    (document.getElementById('cena_cng')).disabled = true;
    (document.getElementById('udrzba')).disabled = true;
    (document.getElementById('elektrina')).disabled = true;
    (document.getElementById('dan_cng')).disabled = true;
    (document.getElementById('vlastni_cng')).disabled = true;
    //nové přepočítání
    calc_ext();
}

function soukroma_stanice() {
    (document.getElementById('cena_verejna')).disabled = true;
    (document.getElementById('cena_cng')).disabled = false;
    (document.getElementById('udrzba')).disabled = false;
    (document.getElementById('elektrina')).disabled = false;
    (document.getElementById('dan_cng')).disabled = false;
    (document.getElementById('vlastni_cng')).disabled = false;
    //nové přepočítání
    calc_ext();
}

function vlastni_cng_hodnota() {
    var cena_cng, udrzba, elektrina, dan_cng, vlastni_cng;
    cena_cng = parseToFloat((document.getElementById('cena_cng')).value);
    if (isNaN(cena_cng)) cena_cng = 0;
    udrzba = parseToFloat((document.getElementById('udrzba')).value);
    if (isNaN(udrzba)) udrzba = 0;
    elektrina = parseToFloat((document.getElementById('elektrina')).value);
    if (isNaN(elektrina)) elektrina = 0;
    dan_cng = parseToFloat((document.getElementById('dan_cng')).value);
    if (isNaN(dan_cng)) dan_cng = 0;
    vlastni_cng = 1.4 * (cena_cng + udrzba + elektrina + dan_cng);
    document.getElementById('cena_vlastni').value = (cislo_format(vlastni_cng, 2, ',', ' ')).toString();
    return vlastni_cng;
}

function calc_basic() {
    if (!kontrola_z()) { return false; };
    var spot_b, cena_b, spot_cng, cena_c, kilometru, cena_prest;
    spot_b = parseToFloat((document.getElementById('sp_benzin')).value);
    cena_b = parseToFloat((document.getElementById('cena_benzin')).value);
    spot_cng = parseToFloat((document.getElementById('sp_cng')).value);
    cena_c = parseToFloat((document.getElementById('cena_cng')).value);
    kilometru = parseToFloat((document.getElementById('kilometry')).value);
    var benzin_rok = kilometru / 100 * spot_b * cena_b;
    var cng_rok = kilometru / 100 * spot_cng * cena_c;
    var benzin_km = cena_b * spot_b / 100;
    var cng_km = cena_c * spot_cng / 100;
    var uspora = benzin_rok - cng_rok;
    var uspora_za_km = benzin_km - cng_km;
    benzin_km = cislo_format(benzin_km, 2);
    cng_km = cislo_format(cng_km, 2);
    benzin_rok = cislo_format(benzin_rok, 0);
    cng_rok = cislo_format(cng_rok, 0);
    uspora = cislo_format(uspora, 0);
    uspora_za_km = cislo_format(uspora_za_km, 2);
    document.getElementById('benzin_rok').innerHTML = benzin_rok.toString();
    document.getElementById('benzin_km').innerHTML = benzin_km.toString();
    document.getElementById('cng_rok').innerHTML = cng_rok.toString();
    document.getElementById('cng_km').innerHTML = cng_km.toString();
    document.getElementById('uspora_rok').innerHTML = uspora.toString();
    document.getElementById('uspora_km').innerHTML = uspora_za_km.toString();
    return true;
}
function calc_ext() {
    if (!kontrola_r()) { return false; };
    var spot_b, cena_b, spot_cng, cena_vlastni, cena_verejna, kilometru, prestavba_cng, vlastni_cng, cena_vlastni_r, cena_verejna_r;
    var cena_cng, udrzba, elektrina, dan_cng;
    cena_cng = parseToFloat((document.getElementById('cena_cng')).value);
    udrzba = parseToFloat((document.getElementById('udrzba')).value);
    elektrina = parseToFloat((document.getElementById('elektrina')).value);
    dan_cng = parseToFloat((document.getElementById('dan_cng')).value);
    spot_b = parseToFloat((document.getElementById('sp_benzin')).value);
    cena_b = parseToFloat((document.getElementById('cena_benzin')).value);
    spot_cng = parseToFloat((document.getElementById('sp_cng')).value);
    cena_vlastni = 1.4 * (cena_cng + udrzba + elektrina + dan_cng);
    cena_verejna = parseToFloat((document.getElementById('cena_verejna')).value);
    kilometru = parseToFloat((document.getElementById('kilometry')).value);
    prestavba_cng = parseToFloat((document.getElementById('prestavba_cng')).value);
    vlastni_cng = parseToFloat((document.getElementById('vlastni_cng')).value);
    cena_vlastni_r = boolToInt((document.getElementById('rb_scs')).checked);
    cena_verejna_r = boolToInt((document.getElementById('rb_vcs')).checked);
    var benzin_rok = kilometru / 100 * spot_b * cena_b;
    var cng_rok = kilometru / 100 * (cena_vlastni * cena_vlastni_r + cena_verejna * cena_verejna_r) * spot_cng;
    var benzin_km = cena_b * spot_b / 100;
    var cng_km = (cena_vlastni * cena_vlastni_r + cena_verejna * cena_verejna_r) * spot_cng / 100;
    var uspora = benzin_rok - cng_rok;
    var uspora_za_km = benzin_km - cng_km;
    var investice = prestavba_cng + vlastni_cng * cena_vlastni_r;
    var amortizace = investice / uspora;
    benzin_km = cislo_format(benzin_km, 2);
    cng_km = cislo_format(cng_km, 2);
    benzin_rok = cislo_format(benzin_rok, 0);
    cng_rok = cislo_format(cng_rok, 0);
    uspora = cislo_format(uspora, 0);
    uspora_za_km = cislo_format(uspora_za_km, 2);
    investice = cislo_format(investice, 0);
    amortizace = cislo_format(amortizace, 1);
    document.getElementById('benzin_rok').innerHTML = benzin_rok.toString();
    document.getElementById('benzin_km').innerHTML = benzin_km.toString();
    document.getElementById('cng_rok').innerHTML = cng_rok.toString();
    document.getElementById('cng_km').innerHTML = cng_km.toString();
    document.getElementById('uspora_rok').innerHTML = uspora.toString();
    document.getElementById('uspora_km').innerHTML = uspora_za_km.toString();
    document.getElementById('investice').innerHTML = investice.toString();
    document.getElementById('amortizace').innerHTML = amortizace.toString();
    return true;
}

function kontrola_z() {
    var result = true;
    var chybnapole = '';
    if (!jeCislo((document.getElementById('sp_benzin')).value)) { chybnapole += '- Petrol or diesel consumption \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_benzin')).value)) { chybnapole += '- Price of petrol or diesel \n'; result = false; }
    if (!jeCislo((document.getElementById('sp_cng')).value)) { chybnapole += '- Consumption of CNG \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_cng')).value)) { chybnapole += '- Price of CNG \n'; result = false; }
    if (!jeCislo((document.getElementById('kilometry')).value)) { chybnapole += '- Km driven annually \n'; result = false; }
    if (result == false) { alert('Input fields contain invalid characters. \nIn addition to numbers, you may type only spaces, decimal coma or dot.\nInvalid fields: \n' + chybnapole); }
    return result;
}
function kontrola_r() {
    var result = true;
    var chybnapole = '';
    if (!jeCislo((document.getElementById('sp_benzin')).value)) { chybnapole += '- Petrol or diesel consumption \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_benzin')).value)) { chybnapole += '- Cena benzínu \n'; result = false; }
    if (!jeCislo((document.getElementById('sp_cng')).value)) { chybnapole += '- Consumption of CNG \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_cng')).value)) { chybnapole += '- Price of CNG \n'; result = false; }
    if (!jeCislo((document.getElementById('udrzba')).value)) { chybnapole += '- Maintenance cost \n'; result = false; }
    if (!jeCislo((document.getElementById('elektrina')).value)) { chybnapole += '- Electricity \n'; result = false; }
    if (!jeCislo((document.getElementById('dan_cng')).value)) { chybnapole += '- Law CNG consumer tax \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_vlastni')).value)) { chybnapole += '- Fuel cost - own refueling appliance \n'; result = false; }
    if (!jeCislo((document.getElementById('cena_verejna')).value)) { chybnapole += '- Fuel cost - public filling station \n'; result = false; }
    if (!jeCislo((document.getElementById('kilometry')).value)) { chybnapole += '- Km driven annually \n'; result = false; }
    if (!jeCislo((document.getElementById('prestavba_cng')).value)) { chybnapole += '- Cost of purchasing new or rebuilding a CNG vehicle \n'; result = false; }
    if (!jeCislo((document.getElementById('vlastni_cng')).value)) { chybnapole += '- Own refueling appliance \n'; result = false; }
    if (result == false) { alert('Input fields contain invalid characters. \n In addition to numbers, you may type only spaces, decimal coma or dot.\nInvalid fields: \n' + chybnapole); }
    return result;
}
function parseToFloat(cislo) {
    cislo = standard(cislo);
    return parseFloat(cislo);
}

function standard(cislo) {
    cislo = cislo.replace(',', '.');
    while (cislo.indexOf(' ') != -1) {
        cislo = cislo.replace(' ', '');
    }
    return cislo;
}

function boolToInt(bool) {
    if (bool == true) return 1;
    else return 0;
}
function jeCislo(value) {
    if (value == '') return false;
    value = standard(value);
    if (parseFloat(value) != (value * 1)) return false;
    return true;
}

function cislo_format(a, b) {
    var c = ',';
    var d = ' ';
    a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
    e = a + '';
    f = e.split('.');
    if (!f[0]) {
        f[0] = '0';
    }
    if (!f[1]) {
        f[1] = '';
    }
    if (f[1].length < b) {
        g = f[1];
        for (i = f[1].length + 1; i <= b; i++) {
            g += '0';
        }
        f[1] = g;
    }
    if (d != '' && f[0].length > 3) {
        h = f[0];
        f[0] = '';
        for (j = 3; j < h.length; j += 3) {
            i = h.slice(h.length - j, h.length - j + 3);
            f[0] = d + i + f[0] + '';
        }
        j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
        f[0] = j + f[0];
    }
    c = (b <= 0) ? '' : c;
    return f[0] + c + f[1];
}
