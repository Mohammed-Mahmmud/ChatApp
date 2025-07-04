<?php $__env->startSection('content'); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Chat')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="alert-success" class="hidden text-green-600 mb-4"></div>
                    <?php if(session()->has('success')): ?>
                        <div id="alert-flash" class="text-green-600 mb-4">
                            <?php echo e(session()->get('success')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2 text-blue-700 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m10-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            Current Users in Room
                        </h3>
                        <div class="relative inline-block w-full">
                            <button id="current-users-btn" type="button" class="w-full bg-blue-100 text-blue-800 rounded shadow-sm px-4 py-2 text-left font-semibold flex items-center justify-between">
                                <span>Current Users in Room</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <ul id="current-users" class="absolute left-0 right-0 bg-white border border-blue-200 rounded shadow-lg mt-1 z-10 hidden max-h-48 overflow-auto"></ul>
                        </div>
                        <div id="user-joined" class="mt-2 text-green-600 font-medium hidden"></div>
                    </div>
                    <form id="chat-form">
                        <?php echo csrf_field(); ?>
                        <div class="mt-4">
                            <label for="user_id"
                                class="block font-medium text-sm text-gray-700">User</label>
                            <select id="user_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
                                required>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="message"
                                class="block font-medium text-sm text-gray-700">Message</label>
                            <textarea id="message" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        // Handle chat form submission
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            let userId = document.getElementById('user_id').value;
            let message = document.getElementById('message').value;
            let token = document.querySelector('input[name="_token"]').value;
            fetch('<?php echo e(route("chat.send")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: userId, message: message })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('alert-success').classList.remove('hidden');
                document.getElementById('alert-success').innerText = 'تم إرسال الرسالة بنجاح';
                document.getElementById('chat-form').reset();
            })
            .catch(error => {
                console.error('خطأ:', error);
            });
        });

        
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mohamed/Documents/projects/ChatApp/resources/views/chat/index.blade.php ENDPATH**/ ?>