ALTER TABLE `fn_profileview`
  ADD CONSTRAINT `fk_profview_viewedusr` FOREIGN KEY (`viewed_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profview_vieweruusr` FOREIGN KEY (`viewer_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_profileview_ibfk_1` FOREIGN KEY (`viewed_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_profileview_ibfk_2` FOREIGN KEY (`viewer_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
