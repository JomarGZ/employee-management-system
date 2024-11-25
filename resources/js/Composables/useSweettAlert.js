import { getCurrentInstance } from "vue";

export function useAlert() {
    const { proxy } = getCurrentInstance();

    return {
        swal: proxy.$swal,
        toast: proxy.$toast,
    }
}