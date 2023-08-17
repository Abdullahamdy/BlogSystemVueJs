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

                    <div class="_overflow _table_div">

                        <editor
                                ref="editor"
                                autofocus
                                holder-id="codex-editor"
                                save-button-id="save-button"
                                :init-data="initData"
                                @save="onSave"
								:config="config"
							/>


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
