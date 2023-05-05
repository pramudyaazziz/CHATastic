<template>
    <form :action="action" @submit.prevent>
        <div class="send-message">
            <div class="input-group flex-nowrap">
                <div class="dropup">
                    <span class="input-group-text" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <i class="bi bi-paperclip fs-5"></i> </span>
                    <ul class="dropdown-menu mb-3">
                        <li>
                            <label class="dropdown-item text-primary" for="image"><i class="bi bi-image-fill me-3"></i>Image</label>
                            <input type="file" id="image" class="d-none" accept="image/*">
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <label class="dropdown-item text-primary" for="document"><i class="bi bi-file-earmark-text-fill me-3"></i>Document</label>
                            <input type="file" id="document" class="d-none" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                        </li>
                    </ul>
                </div>
                <input type="text" class="form-control shadow-none" placeholder="Type a message here..." >
            </div>
            <button type="submit" class="send-button bg-primary">
                <i class="icon-send"></i>
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            action: {
                type: String,
                required: true
            }
        }
    }
</script>
