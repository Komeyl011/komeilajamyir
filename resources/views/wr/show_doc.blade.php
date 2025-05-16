<div class="flex flex-col items-center justify-center w-full p-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden">
        <div class="p-4 bg-gray-100 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Embedded Google Document</h2>
        </div>
        <div class="relative w-full" style="height: 80vh;">
            <iframe
                class="w-full h-full p-0 border-0"
                src="https://docs.google.com/document/d/e/2PACX-1vQSowuJfrJn9VpJG3PnofVRM2a0f5J2BhZS1WvSwTmePkeG9l2N6AeB8mxy233uwQ/pub?embedded=true"
                allowfullscreen>
            </iframe>
        </div>
        <div class="p-4 text-center bg-gray-50">
            <a href="https://docs.google.com/document/d/e/2PACX-1vQSowuJfrJn9VpJG3PnofVRM2a0f5J2BhZS1WvSwTmePkeG9l2N6AeB8mxy233uwQ/pub" 
               target="_blank" 
               class="text-blue-600 hover:underline text-sm font-medium">
                Open in Google Docs
            </a>
        </div>
    </div>
</div>

{{-- @push("javascript")
<script>
    // get all iframes that were parsed before this tag
    var iframes = document.getElementsByTagName("iframe");

    for (let i = 0; i < iframes.length; i++) {
        var url = iframes[i].getAttribute("src");
        if (url.startsWith("https://docs.google.com/document/d/")) {
            // create div and replace iframe
            let d = document.createElement('div');
            d.classList.add("embedded-doc"); // optional
            iframes[i].parentElement.replaceChild(d, iframes[i]);

            // CORS request
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                // display response
                d.innerHTML = xhr.responseText;
            };
            xhr.send();
        }
    }
</script>
@endpush --}}
