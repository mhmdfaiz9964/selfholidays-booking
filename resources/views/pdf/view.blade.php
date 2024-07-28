<!DOCTYPE html>
<html>
<head>
    <title>Hotel PDF Viewer</title>
</head>
<body>
    <h1>Hotel Details</h1>
    
    @if(is_array($hotel->pdf_urls) && count($hotel->pdf_urls) > 0)
        @foreach($hotel->pdf_urls as $pdfUrl)
            <a href="{{ route('hotel.pdf', ['id' => $hotel->id]) }}" target="pdf-frame">View Full PDF</a><br>
        @endforeach
    @else
        <p>No PDFs available.</p>
    @endif

    <iframe id="pdf-frame" style="width: 100%; height: 100vh; border: none;" name="pdf-frame"></iframe>
</body>
</html>
