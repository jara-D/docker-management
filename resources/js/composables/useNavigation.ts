import type { NavItem } from '@/types';
import { readonly, ref } from 'vue';

const navigation = ref<NavItem[]>([]);

export function useNavigation() {
    function setNavigation(items: NavItem[]) {
        navigation.value = items;
    }

    return {
        navigation: readonly(navigation),
        setNavigation,
    };
}
