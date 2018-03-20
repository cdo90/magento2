var config = {
paths: {            
		'jquery' : "js/jquery-2.2.4.min"
        'custom': "js/custom"
    },   
shim: {
    'custom': {
        deps: ['jquery']
    }
}
};