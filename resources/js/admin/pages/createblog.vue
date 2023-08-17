<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        Tags
                        <Button @click="addModal = true" v-if="isWritePermitted">
                            <Icon type="md-add" /> Add tag
                        </Button>
                    </p>

                    <div class="_overflow _table_div blog_editor">
                        <editor ref="editor"
                         autofocus holder-id="codex-editor"
                          save-button-id="save-button"
                            :init-data="initData"
                             @save="onSave"
                             :config="config"
                             />

                        </div>


                        <div class="_input_field">
                            <input type="text" placeholder="title">
                        </div>
                        <div class="_input_field">

                            <Button @click="save">Save</Button>
                        </div>
                </div>
                

            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            config: {
                image: {
                    field: 'image',
                    types: 'image/*',
                },
            },
            initData: null,

            data: {

            },


        };
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() == "") return this.e("Tag Name is required");
            const res = await this.callApi("post", "/app/create_tag", this.data);
            if (res.status == 200) {
                this.tags.unshift(res.data.tag);
                this.s("Tag has been Added Successfully!");
                this.addModal = false;
                this.data.tagName = "";
            } else {
                if ((res.status = 422)) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        onSave(response) {

            console.log(response)

        },
        async save() {
            this.$refs.editor.save();


        }


    },
};
</script>
<style>
.blog_editor {
    width: 717px;
    margin-left: 160px;
    padding: 4px 7px;
    font-size: 14px;
    border: 1px solid #dcdee2;
    border-radius: 4px;
    color: #515a6e;
    background-color: #fff;
    background-image: none;
    z-index: -1;
}

.blog_editor:hover {
    border: 1px solid #57a3f3;
}

._input_field {
    margin: 20px 0 0 160px;
    width: 717px;
}
</style>


