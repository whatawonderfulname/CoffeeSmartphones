// check if storage is available for the current browser
function checkStorageAvailability(type) {
    let storage;

    try {
        storage = window[type];
        let x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    } catch(e) {
        return e instanceof DOMException && (

            // everything except Firefox
            e.code === 22 ||

            // Firefox
            e.code === 1014 ||

            // test name field too, because code might not be present
            // everything except Firefox
            e.name === 'QuotaExceededError' ||

            // Firefox
            e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&

            // acknowledge QuotaExceededError only if there's something already stored
            (storage && storage.length !== 0);
    }
}

// write product cards
function writeCards(id, products) {
    $("#" + id).empty();

    for (let product of products) {
        if (product["old_price"] == "") {
            product["old_price"] = 0;
        }

        $("#" + id).append(`
            <div class="col-sm-6 col-lg-3">
                <a href="${myPath}sessions/common/details.php?category=${product['category']}&id=${product['id']}">
                    <div class="py-4 px-3 py-sm-3 px-sm-2 p-md-2 bg-white text-center">
                        <div class="productImageDiv">
                            <img src="${product['img']}" alt="${product['name']}" class="fittingImage">
                        </div>
                        <p class="myH5 mt-2 mb-0">${product['name']}</p>
                        <span class="myH5 my-0 mr-2">${createCurrencyFormat(parseFloat(product['new_price']))}</span>
                        <span class="myP my-0"><s>${createCurrencyFormat(parseFloat(product['old_price']))}</s></span>
                        <div>
                            <span class="ratings">${createStars(product['stars'])}</span>
                            <span class="ratings">${product['ratings']}</span>
                        </div>
                    </div>
                </a>
            </div>
        `);
    }
}

// give a numeric string a currency format
function createCurrencyFormat(numericString) {
    if (numericString != 0) {
        return new Intl.NumberFormat("de-DE", {style: "currency", currency: "EUR"}).format(numericString);
    } else {
        return "";
    }
}

// create star elements
function createStars(integer) {
    let result = '';

    if (integer > 0) {
        for (let i = 0; i < integer; i++) {
            result += '<span class="fullStar myP">&starf;</span>';
        }
        
        for (i = 0; i < 5 - integer; i++) {
            result += '<span class="emptyStar myP">&star;</span>';
        }
    } else {
        result = '<span class="notRated myP">not rated</span>';
    }
    
    return result;
}