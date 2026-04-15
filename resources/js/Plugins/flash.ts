import { router } from '@inertiajs/vue3';
import { notify } from 'notiwind';

export default () => {
    router.on('success', (event) => {
        const flash = event.detail.page.props.flash;

        if (flash?.message) {
            notify(
                {
                    group: 'foo',
                    title: flash.type === 'success' ? 'Success' : 'Info',
                    text: flash.message,
                },
                4000,
            );
        }
    });

};
