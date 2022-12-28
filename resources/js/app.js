import "./bootstrap";

import * as coreui from "@coreui/coreui";
import Alpine from "alpinejs";
import focus from "@alpinejs/focus";

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
