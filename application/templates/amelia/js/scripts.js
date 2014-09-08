( function() {
        if (window.CHITIKA === undefined) {
            window.CHITIKA = {
                'units' : []
            };
        }

        var unit = {
            'client' : 'isnare2',
            'force_rtb' : true,
            'width' : 300,
            'height' : 250,
            'sid' : window.ch_channel ? window.ch_channel : 'ab_intext_article',
            'cid' : '300x250',
            'alternate_ad_url' : '',
            'cpm_floor' : .99
        }

        var placement_id = window.CHITIKA.units.length;
        window.CHITIKA.units.push(unit);

        document.write('<div id="chitikaAdBlock-' + placement_id.toString() + '"></div>');

        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.src = 'http://scripts.chitika.net/getads.js';

        try {
            document.getElementsByTagName('head')[0].appendChild(s);
        } catch(e) {
            document.write(s.outerHTML);
        }
}());