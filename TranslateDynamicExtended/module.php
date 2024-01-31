<?php

	class TranslateDynamicExtended extends IPSModule
	{

		public function GetConfigurationForm()
		{
			return file_get_contents(__DIR__ . '/global/form.json');
		}

		public function DoText()
		{
			// You cannot use IPS_Translate externally anymore. Therefore always translate in special functions
			return sprintf($this->Translate("The current time is %s"), date("d.m.y H:i"));
		}

		public function Translate($Text)
		{
            $translation = json_decode(file_get_contents(__DIR__ . '/global/locale.json'), true);
            $language = IPS_GetSystemLanguage();
            $code = explode('_', $language)[0];
            if (isset($translation['translations'])) {
                if (isset($translation['translations'][$language])) {
                    if (isset($translation['translations'][$language][$Text])) {
                        return $translation['translations'][$language][$Text];
                    }
                } elseif (isset($translation['translations'][$code])) {
                    if (isset($translation['translations'][$code][$Text])) {
                        return $translation['translations'][$code][$Text];
                    }
                }
            }
            return $Text;
		}

	}

?>
