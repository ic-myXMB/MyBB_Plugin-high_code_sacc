/*
 * MyBB: Highlight Code Select All Copy Code
 *
 * File: high_code_sacc_init.js
 * 
 * Authors: Vintagedaddyo & ic_myXMB
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.0.3
 * 
 */

// Init HighlightJS
// add event
document.addEventListener('DOMContentLoaded', (event) => {
     // wrap code tags in pre tags
	 $('code').wrap('<pre></pre>');	
	 // query el
     document.querySelectorAll('code').forEach((el) => {
       // Init
       hljs.highlightElement(el);
    });
});

// brPlugin
const brPlugin = {
	// before
    "before:highlightElement": ({ el }) => {
      // inner html
      el.innerHTML = el.innerHTML.replace(/\n/g, '').replace(/<br[ /]*>/g, '\n');
    },
    // after
    "after:highlightElement": ({ result }) => {
      // result value
      result.value = result.value.replace(/\n/g, '<br>');
    }
};
// Init brPlugin
hljs.addPlugin(brPlugin);	

// Line Numbers Plugin	
(function (w, d) {
    if (w.hljs) {
    	// init
        w.hljs.initLineNumbersOnLoad = initLineNumbersOnLoad;
        // add
        w.hljs.addLineNumbersForCode = addLineNumbersForCode;
    } else {
    	// error
        w.console.error('highlight.js not detected!');
    }
    // initLineNumbersOnLoad
    function initLineNumbersOnLoad() {
    	// ready states
        if (d.readyState === 'interactive' || d.readyState === 'complete') {
        	// ready
            documentReady();
        } else {
            w.addEventListener('DOMContentLoaded', function () {
            	// ready
                documentReady();
            });
        }
    }
    // addLineNumbersForCode
    function addLineNumbersForCode(html) {
    	// num
        var num = 1;
        // html
        html = '<span class="ln-num" data-num="' + num + '"></span>' + html;
        html = html.replace(/\r\n|\r|\n/g, function (a) {
        	// num
            num++;
            // return
            return a + '<span class="ln-num" data-num="' + num + '"></span>';
        });
        // html
        html = '<span class="ln-bg"></span>' + html;
        // return
        return html;
    }
    // documentReady
    function documentReady() {
        var elements = d.querySelectorAll('.hljs');
        // for
        for (var i = 0; i < elements.length; i++) {
        	// if
            if (elements[i].className.indexOf('hljs-ln') == -1) {
            	// html
                var html = elements[i].innerHTML;
                html = addLineNumbersForCode(html);
                elements[i].innerHTML = html;
                // add
                elements[i].classList.add('hljs-ln');
            }
        }
    }
}(window, document));

// Init Line Numbers Plugin
hljs.initLineNumbersOnLoad();
