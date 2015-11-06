ALTER TABLE `fn_uploaddetails`
  ADD CONSTRAINT `fk_upload_sourcetype` FOREIGN KEY (`upload_sourcetype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_upload_type` FOREIGN KEY (`uploadtype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_uploaddetails_ibfk_1` FOREIGN KEY (`upload_sourcetype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_uploaddetails_ibfk_2` FOREIGN KEY (`uploadtype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
