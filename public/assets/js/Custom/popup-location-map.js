
(function(){

    this.CivicApp = this.CivicApp || {};
    this.CivicApp.PopUpLocation =  new function() {
        debugger;
        var map= null;
        var locationInput = $('#autocompletepopUpMap');
        var popUpModal = $('#popUpLocation');

        var InitializeMap = function()
        {
            map = new CivicApp.GmapHelper2.Map();
            var initmapPopUp = map.InitMap('popUpMap');
            initmapPopUp.then(function() {
                map.southWest = '-31.471168, -64.278946';
                map.northEast = '-31.361003, -64.090805';
                map.CreateSearchBox('autocompletepopUpMap');
                map.AddEventClickAddMarker();

            });
        };


        var mapPopUp = function()
        {
            return map;
        };

        var DisplayPopUpLocation = function()
        {
            popUpModal.modal('show');
        };

        var HidePopUpLocation = function()
        {
            popUpModal.modal('hide');
        };

        var AddCallBackSave = function(callback)
        {
            $('#savepopUpLocation').on('click',callback);
        };

        var AddCallBackShownModal = function(callback)
        {
            popUpModal.on('shown.bs.modal',callback);
        };

        var AddCallBackHideModal = function(callback)
        {
            popUpModal.on('hide.bs.modal',callback);
        };

        var ResizeMap = function()
        {
            google.maps.event.trigger(map.map, 'resize');
        };



        return {
            mapPopUp: mapPopUp,
            InitializeMap : InitializeMap,
            AddCallBackShownModal: AddCallBackShownModal,
            AddCallBackSave: AddCallBackSave,
            AddCallBackHideModal:AddCallBackHideModal,
            ResizeMap:ResizeMap,
            HidePopUpLocation : HidePopUpLocation,
            DisplayPopUpLocation: DisplayPopUpLocation

        }


    };
})();


$(document).ready(function(){



});
