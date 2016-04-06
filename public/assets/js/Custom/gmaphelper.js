/**
 * Created by Nico on 28/03/2016.
 */

(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.GmapHelper = this.CivicApp.GmapHelper || {};
}());

CivicApp.GmapHelper.AutocompleteChange = function()
{

        var place = placesAutocomplete.getPlace();
        if (place.geometry) {
            map.panTo(place.geometry.location);
            map.setZoom(18);
        } else {
            document.getElementById('autocompleteMap').placeholder = 'Enter a city';
        }

}