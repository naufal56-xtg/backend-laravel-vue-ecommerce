import toastr from "toastr";
// import "../assets/vendor/libs/toastr/toastr.js";
import "../assets/js/ui-toasts.js";

export function useToastr() {
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    return toastr;
}
