<div class=column">
    <form action="/upload" method="post" enctype="multipart/form-data" class="ui form">
        @csrf
        <div class="field">
            <input type="file" name="csvfile" />
        </div>
        <input class="ui blue button"  type="submit" name="Upload" />
    </form>
</div>
