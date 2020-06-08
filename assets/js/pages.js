$(function () {
	/* CKEditor */
	CKEDITOR.disableAutoInline = true;
	let ckwrites = $('body').find('.ckwrite');
	ckwrites.each(function (i, e) {
		CKEDITOR.replace(e.name, {
			customConfig: '/bucte/admin/assets/js/ck_pages.js'
		});
	});

	let ckwritesV = $('body').find('.ckwriteV');
        ckwritesV.each(function(i, e) {
            CKEDITOR.replace(e.name, {
                customConfig: '/bucte/admin/assets/js/ck_pages.js'
            });
        });

    let ckwritesM = $('body').find('.ckwriteM');
        ckwritesM.each(function(i, e) {
            CKEDITOR.replace(e.id, {
                customConfig: '/bucte/admin/assets/js/ck_pages.js'
        });
    });

    let ckwritesO = $('body').find('.ckwriteO');
    ckwritesO.each(function(i, e) {
        CKEDITOR.replace(e.id, {
              customConfig: '/bucte/admin/assets/js/ck_pages.js'
        });
    });

});

function InstanceCKE() {
	for (instance in CKEDITOR.instances) {
		CKEDITOR.instances[instance].updateElement();
	}
}

function ClearCKE() {
	InstanceCKE();
	CKEDITOR.instances[instance].setData('');
}
