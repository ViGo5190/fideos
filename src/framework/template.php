<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

/**
 * @param $templateName
 * @param array $variables
 * @return string
 */
function framework_template_compileTemplate($templateName, $variables = [])
{
    $tplFile = __DIR__ . '/../../templates/' . $templateName . '.phtml';
    if (!file_exists($tplFile)) {
        die('Template not found');
    }

    if (is_array($variables) && !empty($variables)) {
        extract($variables);
    }

    ob_start();
    require($tplFile);
    $compiledTemplate = ob_get_contents();
    ob_end_clean();

    return $compiledTemplate;
}