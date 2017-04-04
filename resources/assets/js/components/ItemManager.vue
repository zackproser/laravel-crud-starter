<template>
    <div>
        <div v-if="hasMessage" class="alert" v-bind:class="{ 'alert-success': messageType === 'success', 'alert-danger': messageType === 'error' }">{{ message }}</div>

        <!-- BEGIN No items notification -->
        <div v-if="items.length === 0">

            <div class="alert alert-warning">Currently there are no items.</div>

        </div>
        <!-- END No items notification -->

        <!-- BEGIN items Table -->
        <div v-if="items.length > 0" class="table-wrapper">

            <div class="btn-group admin-controls">
                <button v-on:click="displayNewModal" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add item</button>
            </div>

            <!--Loop through items and render a table row for each, with edit and delete icons bound to handlers -->
            <table class="table table-striped admin">

                <thead>
                    <th>Name</th>
                    <th>Thumbnail</th>
                    <th>Type</th>
                    <th>Created</th>
                    <th>Last Updated</th>
                </thead>
                <tbody>
                    <tr :id="item.id" v-for="item in items">
                        <td>
                            <div class="row">
                                <div class="col-md-12">
                                    {{ item.name }}
                                </div>
                                <div class="col-md-12">
                                    <i v-on:click="handleDelete(item.id)" :data-candidatename="item.name" :id="item.id" class="glyphicon glyphicon-remove-circle delete-icon"></i>

                                    <i v-on:click="displayEditModal(item.id)" :data-candidatename="item.name" :id="item.id" class="glyphicon glyphicon-pencil edit-icon"></i>
                                </div>
                            </div>
                        </td>
                        <td class="item-thumbnail"><img class="thumbnail" :src="item.image_url" /> </td>
                        <td>{{ item.type }}</td>
                        <td>{{ item.created_at | formatDate }}</td>
                        <td>{{ item.updated_at | formatDate }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <!-- END items Table -->

        <hr>

        <!-- BEGIN Delete Modal -->
        <div id="confirm" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to delete {{ targetItem.name }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete {{ targetItem.name }}</button>
                        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Delete Modal -->

        <!-- BEGIN Edit Modal -->
        <div id="edit" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Edit item
                    </div>
                    <div class="modal-body">
                        <div v-if="validationErrors.length > 0" class="alert alert-danger">
                            <span>Validation Errors:</span>
                            <ul>
                                <li v-for="validationError in validationErrors">
                                    {{ validationError | plaintext }}
                                </li>
                            </ul>
                        </div>
                        <form>
                            <div class="form-group" v-bind:class="{ 'has-error': validationErrors.length > 0 }">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" v-model="targetItem.name"/>
                                <label for="image_url">Image URL</label>
                                <input type="text" name="image_url" class="form-control" v-model="targetItem.image_url" />
                                <label for="democrat">Type1</label>
                                <input type="radio" name="type1" id="type1" value="type1" v-model="targetItem.type">
                                <br>
                                <label for="type2">Type2</label>
                                <input type="radio" name="type2" id="type2" value="type2" v-model="targetItem.type">
                                <br>
                                <label for="type3">Type3</label>
                                <input type="radio" name="type3" id="type3" value="type3" v-model="targetItem.type">
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button v-on:click.stop.prevent="handleEdit(targetItem.id)" type="button" data-dismiss="modal" class="btn btn-primary">Update {{ targetItem.name }}</button>
                                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Edit Modal -->

        <!-- BEGIN Create Modal-->
        <div id="create" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Create New item
                    </div>
                    <div class="modal-body">
                        <div v-if="validationErrors.length > 0" class="alert alert-danger">
                            <span>Validation Errors:</span>
                            <ul>
                                <li v-for="validationError in validationErrors">
                                    {{ validationError | plaintext }}
                                </li>
                            </ul>
                        </div>
                        <form>
                            <div class="form-group" v-bind:class="{ 'has-error': validationErrors.length > 0 }">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" v-model="newItem.name"/>
                                <label for="image_url">Image URL</label>
                                <input type="text" name="image_url" class="form-control" v-model="newItem.image_url" />
                                <label for="type1">Type1</label>
                                <input type="radio" name="type1" id="type1" value="type1" v-model="newItem.type">
                                <br>
                                <label for="type2">Type2</label>
                                <input type="radio" name="type2" id="type2" value="type2" v-model="newItem.type">
                                <br>
                                <label for="type3">Type3</label>
                                <input type="radio" name="type3" id="type3" value="type3" v-model="newItem.type">
                                <br>
                                <div class="modal-footer">
                                    <button v-on:click.stop.prevent="handleCreate" type="buton" data-dismiss="modal" class="btn btn-primary">Add {{ newItem.name }}</button>
                                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Create Modal-->
    </div>
</template>

<script>
    export default {
        name: 'adminclient',
        /**
         * Similar to an init, we can use this hook to do any setup work
         *
         * In this case, fetch the items list from the backend API
         *
         * @return void
         */
        mounted() {
            this.getItemsList();
        },
        data() {
            return {
                message: '',
                hasMessage: false,
                messageType: 'error',
                validationErrors: [],
                items: [],
                newItem: { name: '', thumbnail: '', type: 'type1' },
                targetItem: { name: '', thumbnail: '', type: 'type1' },
                fadeInTime: 1800,
                fadeOutTime: 1800
            }
        },
        methods: {
            /**
             * Display an error message to the user, above the items table
             *
             * Handles either a string or an Error, such as those returned by the backend API
             *
             * Usage: this.showMessage('arbitray message string', 'success');
             *
             * @param {Object} msg The message object to handle and display
             *
             * @param {String} type - either 'success' or 'error'
             *
             * @return void
             */
            showMessage(msg, type) {
                this.resetMessage();
                this.message = (typeof msg === "object" && msg instanceof Error && msg.message) ? msg.message : msg;
                this.messageType = type;
                this.hasMessage = true;
                setTimeout(this.resetMessage, this.fadeOutTime);
            },
            /**
             * Handle an error response from the backend
             *
             * An HTTP Status code of 422 indicates validation errors
             *
             * @param  {Object} error The Error object returned by the backend REST API
             *
             * @return void
             */
            handleAPIError(error) {
                //Status code 422 signals a validation error server-side
                if (error.response.status && error.response.status === 422 && typeof error.response.data === "object") {
                    //Update validationErrors array so that forms can render them
                    this.validationErrors = _.values(error.response.data);
                } else {
                    this.showMessage(`Error updating ${this.targetItem.name}: ${error.message}`, 'error');
                }
            },
            /**
             * Reset error / success message
             *
             * @return void
             */
            resetMessage() {
                this.hasMessage = false;
                this.message = '';
            },
            /**
             * Reset all validation errors and modals
             *
             * Convenience method for calling after a successful REST operation
             *
             * @return void
             */
            resetModals() {
                this.validationErrors = [];
                _.each($('.modal'), (modal) => {
                    $(modal).modal('hide');
                });
            },
            /**
             * Fadeout a table row, then remove it from the dom
             *
             * @param  {Object} targetRow jQuery wrapped element
             *
             * @return void
             */
            animateRowRemoved(targetRow) {
                $(targetRow).fadeOut(this.fadeOutTime, (() => {
                    $(this).remove();
                }));
            },
            /**
             * Provide visual highlighting to a successfully updated row
             *
             * You can adjust the duration by modifying the 'fadeOutTime' property returned
             * by this Vue instance's data() method
             *
             * @param  {Object} targetRow jQuery wrapped element to highlight
             *
             * @return void
             */
            animateRowUpdated(targetRow) {
                $(targetRow).addClass('success');
                setTimeout(() => {
                    $(targetRow).removeClass('success');
                }, this.fadeOutTime);
            },
            /**
             * Create a new item record via the backend API
             *
             * @return void
             */
            handleCreate() {
                //Issue POST ajax request
                axios.post(`/api/items`, this.newItem).then((response) => {
                    if (response.status && response.status === 200) {
                        this.showMessage(`Successfully created ${this.newItem.name}`, 'success');
                        this.resetModals();
                        this.getItemsList();
                    }
                })
                .catch((error) => {
                    this.handleAPIError(error);
                });
            },
            /**
             * Edit a item via a PUT ajax request to the items REST API
             *
             * @param  {Number} editId The ID of the item record to edit
             *
             * @return void
             */
            handleEdit() {
                //The target row we will highlight if this operation completes successfully
                let targetRow = $('.table').find(`tr#${this.targetItem.id}`);
                //Issue PUT ajax request
                axios.patch(`/api/items/${this.targetItem.id}`, this.targetItem).then((response) => {
                    if (response.status && response.status === 200) {
                        this.showMessage(`Successfully updated ${this.targetItem.name}`, 'success');
                        this.resetModals();
                        this.animateRowUpdated($(targetRow));
                    }
                })
                .catch((error) => {
                    this.handleAPIError(error);
                });
            },
            /**
             * Delete a item via a DELETE ajax request to the items REST API
             *
             * On delete success, handles updating the table by removing the row and
             * displaying a delete success message to the user
             *
             * @param  {Number} The ID of the item selected for deletion
             *
             * @return void
             */
            handleDelete(deleteId) {
                //Find item's table row by id
                let targetRow = $('.table').find(`tr#${deleteId}`);
                //Find item by id
                this.targetItem = this.items.find((item) => { return item.id === deleteId });
                //Prevent accidental item deletion by requiring delete confirmation via modal
                this.confirmDeletion();
                //Only if user confirms deletion, proceed with the request to the backend
                $('#delete').one('click', () => {
                    //Issue DELETE ajax request
                    axios.delete(`/api/items/${deleteId}`).then((response) => {
                        if (response.status && response.status === 200) {
                            this.showMessage(`Successfully deleted ${this.targetItem.name}`, 'success');
                            this.animateRowRemoved($(targetRow));
                        }
                    })
                    .catch((error) => {
                        this.showMessage(`Oops. There was an issue deleting ${targetItem}: ${error.message}`, 'error');
                    });
                });
            },
            /**
             * Display the create item modal
             *
             * @return void
             */
            displayNewModal() {
                this.resetModals();
                $('#create').modal('show');
            },
            /**
             * Dispay the item edit modal
             *
             * @return void
             */
            displayEditModal(editId) {
                this.targetItem = this.items.find((item) => { return item.id === editId });
                $('#edit').modal('show');
            },
            /**
             * Display the item delete confirmation modal
             *
             * @return void
             */
            confirmDeletion() {
                $('#confirm').modal('show');
            },
            /**
             * Fetches the list of items from the server
             *
             * If items exist and are successfully returned, updates this Vue instance's items array
             *
             * @return void
             */
            getItemsList() {
                axios.get('/api/items').then((response) => {
                   if (typeof response.data != "undefined") {
                        this.items = response.data;
                   }
                })
                .catch((error) => {
                    this.handleAPIError(error);
                });
            }
        }
    }
</script>
