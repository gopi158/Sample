ALTER TABLE `fn_user_finao_journal`
  ADD CONSTRAINT `fk_usrfinaojou_creby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinaojou_finaoid` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinaojou_updby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_2` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_3` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
