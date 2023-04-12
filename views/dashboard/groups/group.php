<section class="groupSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="index.php" class="w-75 mx-auto">
            <div class=" mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Description</label>
                <input type="email" class="form-control" name="description" id="description">
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>

            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-primary me-1 rounded-1" name="action" value="Create">
                <a href="/home" class="btn btn-danger">cancel</a>
            </div>
        </form>

    </div>
</section>