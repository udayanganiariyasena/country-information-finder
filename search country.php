<?php
    $url = "https://restcountries.com/v3.1/all";
    $data = file_get_contents($url);
    $data = json_decode($data, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>REST_Countries</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Select a Country :</h2>
                <form action="" method="post" style="position: relative;">
                    <div class="form-group">
                        <select class="form-control" id="myDropdown" name="countries">
                            <option>- - Select a country - -</option>
                            <?php
                                for ($x = 0; $x <= 200; $x++) {
                                    $cname = $data[$x]['name']['common'];
                                    echo "<option value='$x'>$cname</option>";
                                }
                            ?>
                        </select>
                    </div>
                </form>
                <div id="selectedCountryTLD" style="display:none">TLD: <span id="tldValue"></span></div>
            </div>
        </div>
    </div>

    <div class="container2" style="display: none; padding-left: 10%; padding-right:10%;">
        <table width="100%" class="table">
            <tr style="text-align:center;">
                <th colspan="2"><h4 id="officialValue"></h4></th>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center;">
                    <img id="flagImage" src="" alt="Flag">
                </th>
            </tr>
            <tr>
                <td>Capital City</td>
                <td id="capitalValue"></td>
            </tr>
            <tr>
                <td>Region</td>
                <td id="regionValue"></td>
            </tr>
            <tr>
                <td>Sub Region</td>
                <td id="subRegionValue"></td>
            </tr>
            <tr>
                <td>Currency</td>
                <td id="currencyValue"></td>
            </tr>
            <tr>
                <td>Country Code</td>
                <td id="countryCodeValue"></td>
            </tr>
            <tr>
                <td>Population</td>
                <td id="populationId"></td>
            </tr>
            <tr>
                <td>Area</td>
                <td id="areaValue"></td>
            </tr>
            <tr>
                <td>Borders</td>
                <td id="bordersValue"></td>
            </tr>
            <tr>
                <td>Google Map Link</td>
                <td>
                    <a id="mapValue" href="" target="_blank">Google Map</a>
                </td>
            </tr>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById("myDropdown").addEventListener("change", function () {
            var selectedIndex = this.value;
            if (selectedIndex >= 0) {
                var selectedCountry = <?php echo json_encode($data); ?>[selectedIndex];
                var tld = selectedCountry['tld'][0];
                var flagURL = selectedCountry['flags']['png'];
                var capital = selectedCountry['capital'][0];
                var region = selectedCountry['region'];
                var subRegion = selectedCountry['subregion'];
                var countryCode = selectedCountry['ccn3'];
                var populationValue = selectedCountry['population'];
                var area = selectedCountry['area'];
                var borders = selectedCountry['borders'];
                var currencies = selectedCountry['currencies'];
                var googleMapsURL = selectedCountry['maps']['googleMaps'];
                var officialName = selectedCountry['name']['official'];

                var currencyInfo = [];
                for (var currencyCode in currencies) {
                    if (currencies.hasOwnProperty(currencyCode)) {
                        var currencyName = currencies[currencyCode]['name'];
                        currencyInfo.push(currencyName);
                    }
                }
                var currencyNames = currencyInfo.join(', ');
                
                var borderCountries = "There is no borders data";
                if (Array.isArray(borders) && borders.length > 0) {
                    borderCountries = borders.join(', ');
                }

                document.getElementById("tldValue").textContent = tld;
                document.getElementById("capitalValue").textContent = capital;
                document.getElementById("regionValue").textContent = region;
                document.getElementById("subRegionValue").textContent = subRegion;
                document.getElementById("currencyValue").textContent = currencyNames;
                document.getElementById("countryCodeValue").textContent = countryCode;
                document.getElementById("populationId").textContent = populationValue;
                document.getElementById("areaValue").textContent = area;
                document.getElementById("officialValue").textContent = officialName;
                document.getElementById("bordersValue").textContent = borderCountries;
                document.getElementById("flagImage").src = flagURL;
                document.getElementById("mapValue").href = googleMapsURL;
                document.querySelector(".container2").style.display = "block";
            } else {
                document.querySelector(".container2").style.display = "none";
            }
        });
    </script>
</body>
</html>
