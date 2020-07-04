<form action="{{ route('file_upload_local.upload_post') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="hinh">
    <br>
    <br>
    <input type="submit" value="Upload">
</form>
